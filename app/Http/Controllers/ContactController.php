<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Services\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * The contact service.
     *
     * @var contactService
     */
    protected $contactService;

    /**
     * Create a new controller instance.
     *
     * @param  ContactService  $contactService
     * @return void
     */
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json([
            'contacts' => $request->user()->contacts
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        return response()->json([
            'contact' => $this->contactService->addContact($request)
        ], 200); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateContactRequest $request)
    {
        $contact = $request->user()->contacts()->findOrFail($id);

        return response()->json([
            'contact' => $this->contactService->update($contact, $request)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = request()->user()->contacts()->findOrFail($id);

        return response()->json([
            'success' => $this->contactService->delete($contact)
        ], 200);
    }

    /**
     * Ger request user contacts as CSV.
     *
     * @param  \Illuminate\Http\Request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function userContactsToCsv(Request $request)
    {
        return $this->contactService->userContactsToScv($request->user());
    }
}
