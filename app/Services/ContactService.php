<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\User;
use Klaviyo\Klaviyo;
use Klaviyo\Model\ProfileModel as KlaviyoProfile;

class ContactService
{
    /**
     * Klaviyo client.
     *
     * @var Klaviyo
     */
    protected $claviyo;

    /**
     * Create a new instance.
     *
     * @param  Klaviyo  $klaviyo
     * @return void
     */
    public function __construct(Klaviyo $klaviyo)
    {
        $this->klaviyo = $klaviyo;
    }

    /**
     * Add contact to the db and sync with Klaviyo
     *
     * @param  StoreContactRequest  $request
     * @return mixed null|Contact
     */
    public function addContact($request)
    {
        $contact = $request->user()
            ->contacts()
            ->create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone
            ]);

        if (!$contact) {
            return null;
        }

        $profile = new KlaviyoProfile([
            '$email'        => $contact->email,
            '$first_name'   => $contact->name,
            '$phone_number' => $contact->phone
        ]);

        $identified = $this->klaviyo->publicAPI->identify($profile, true);

        if ($identified != 1) {
            logger()->error(
                'Failed to identify profile at Klaviyo',
                ['profile' => $profile]
            );
        }

        return $contact;
    }

    /**
     * Update contact and sync with Klaviyo
     *
     * @param  Contact  $contact
     * @param  UpdateContactRequest  $request
     * @return Contact $contact
     */
    public function update($contact, $request)
    {
        try {
            $profileId = $this->klaviyo->profiles->getProfileIdByEmail($contact->email);

            $contact->update([
                'email' => $request->email,
                'name'  => $request->name,
                'phone' => $request->phone        
            ]);

            $this->klaviyo->profiles->updateProfile(
                $profileId['id'],
                [
                    '$email'        => $request->email,
                    '$first_name'   => $request->name,
                    '$phone_number' => $request->phone
                ]
            );
        } catch (\Throwable $th) {
            logger()->error($th->getMessage(), [
                'contact' => $contact->attributesToArray(),
                'request' => $request->input()
            ]);
        }

        $contact->refresh();

        return $contact;
    }

    /**
     * Delete contact and sync with Klaviyo
     *
     * @param  Contact  $contact
     * @return bool
     */
    public function delete($contact): bool
    {
        try {
            $deletionRequest = $this->klaviyo->dataPrivacy->requestProfileDeletion($contact->email);

            logger($deletionRequest, ['contact' => $contact->attributesToArray()]);
        } catch (\Throwable $th) {
            logger()->error($th->getMessage(), ['contact' => $contact->attributesToArray()]);
        }

        $deleted = $contact->delete();

        return $deleted ?? false;
    }

    /**
     * Import User's contacts to CSV
     *
     * @param  User  $user
     * @return bool
     */
    public function userContactsToScv($user)
    {
        $contacts = $user->contacts()->cursor();

        $filename = 'contacts.csv';

        $headers = [
            'Expires'                   => now() . ' ' . 'GMT',
            'Last-Modified'             => now() . ' ' . 'GMT',
            'Cache-Control'             => 'max-age=0, no-cache, must-revalidate',
            'Content-Type'              => 'application/force-download',
            'Content-Type'              => 'application/octet-stream',
            'Content-Type'              => 'application/download',
            'Content-Type'              => 'text/csv',
            'Content-Disposition'       => "attachment;filename={$filename}",
            'Content-Transfer-Encoding' => 'binary',
        ];

        $bufferized = function () use ($contacts) {
            ob_start();

            $buffer = fopen('php://output', 'w');

            fputcsv($buffer, ['name', 'email', 'phone_number']);

            foreach ($contacts as $contact) {
                fputcsv(
                    $buffer,
                    [
                        $contact->name,
                        $contact->email,
                        $contact->phone
                    ]
                );
            }

            fclose($buffer);

            echo ob_get_clean();
        };

        return response()->streamDownload(
            $bufferized,
            $filename,
            $headers
        );
    }
}
