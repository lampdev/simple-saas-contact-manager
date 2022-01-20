<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Contacts
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <button class="basis-1/2 p-6 bg-white border-b border-gray-200 hover:bg-sky-700" @click="countClick">
                        Click me!
                    </button>
                    <button class="basis-1/2 p-6 bg-white border-b border-gray-200 hover:bg-sky-700" @click="downloadCsv">
                        Download CSV
                    </button>
                </div>
            </div>
        </div>

        <div class="accordion max-w-7xl mx-auto sm:px-6 lg:px-8" id="add-new-contact">
            <div class="accordion-item bg-white border border-gray-200">
                <h2 class="accordion-header mb-0" id="add-new-contact-heading">
                    <button
                        class="
                          accordion-button
                          collapsed
                          relative
                          flex
                          items-center
                          w-full
                          py-4
                          px-5
                          text-base text-gray-800 text-left
                          bg-white
                          border-0
                          rounded-none
                          transition
                          focus:outline-none
                        "
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#add-new-contact-collapse"
                        aria-expanded="false"
                        aria-controls="add-new-contact-collapse"
                    >
                        Add New Contact
                    </button>
                </h2>
                <div
                  id="add-new-contact-collapse"
                  class="accordion-collapse collapse"
                  aria-labelledby="add-new-contact-heading"
                  data-bs-parent="#add-new-contact"
                >
                    <div class="accordion-body py-4 px-5 flex flex-row">
                        <div class="basis-1/2">
                            <div class="flex justify-start">
                                <div>
                                    <div class="form-floating mb-3 xl:w-96">
                                        <input type="name" class="form-control
                                            block
                                            w-full
                                            px-3
                                            py-1.5
                                            text-base
                                            font-normal
                                            text-gray-700
                                            bg-white bg-clip-padding
                                            border border-solid border-gray-300
                                            rounded
                                            transition
                                            ease-in-out
                                            m-0
                                            focus:text-gray-700
                                            focus:bg-white
                                            focus:border-blue-600
                                            focus:outline-none"
                                            id="floatingName"
                                            placeholder="name"
                                            v-model="contactForm.name"
                                        >
                                        <label for="floatingName" class="text-gray-700">Name</label>
                                        <div class="text-sm text-red-500 mt-1" v-if="contactForm.errors.name">{{ contactForm.errors.name }}</div>
                                    </div>
                                    <div class="form-floating mb-3 xl:w-96">
                                        <input type="email" class="form-control
                                            block
                                            w-full
                                            px-3
                                            py-1.5
                                            text-base
                                            font-normal
                                            text-gray-700
                                            bg-white bg-clip-padding
                                            border border-solid border-gray-300
                                            rounded
                                            transition
                                            ease-in-out
                                            m-0
                                            focus:text-gray-700
                                            focus:bg-white
                                            focus:border-blue-600
                                            focus:outline-none"
                                            id="floatingEmail"
                                            placeholder="name@example.com"
                                            v-model="contactForm.email"
                                        >
                                        <label for="floatingEmail" class="text-gray-700">Email address</label>
                                        <div class="text-sm text-red-500 mt-1" v-if="contactForm.errors.email">{{ contactForm.errors.email }}</div>
                                    </div>
                                    <div class="form-floating mb-3 xl:w-96">
                                        <input type="phone" class="form-control
                                            block
                                            w-full
                                            px-3
                                            py-1.5
                                            text-base
                                            font-normal
                                            text-gray-700
                                            bg-white bg-clip-padding
                                            border border-solid border-gray-300
                                            rounded
                                            transition
                                            ease-in-out
                                            m-0
                                            focus:text-gray-700
                                            focus:bg-white
                                            focus:border-blue-600
                                            focus:outline-none"
                                            id="floatingPhone"
                                            placeholder="Phone number"
                                            v-model="contactForm.phone"
                                        >
                                        <label for="floatingPhone" class="text-gray-700">Phone number</label>
                                        <div class="text-sm text-red-500 mt-1" v-if="contactForm.errors.phone">{{ contactForm.errors.phone }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="basis-1/2">
                            <button type="button" @click="saveContact" class="inline-block mx-7 px-7 py-3 bg-sky-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-sky-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-sky-800 active:shadow-lg transition duration-150 ease-in-out">Save Contact</button>
                            <button type="button" @click="clearContact" class="inline-block mx-7 px-7 py-3 bg-red-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Clear Form</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div 
                    v-for="contact in contacts"
                    :key="contact.id"
                >
                    <input v-model="contact.name" class="
                        form-control
                        w-1/4
                        px-2
                        py-1
                        text-sm
                        font-normal
                        text-gray-700
                        bg-white bg-clip-padding
                        border border-solid border-gray-300
                        rounded
                        transition
                        ease-in-out
                        mb-1
                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    >
                    <input v-model="contact.email" class="form-control
                        w-1/4
                        px-2
                        py-1
                        text-sm
                        font-normal
                        text-gray-700
                        bg-white bg-clip-padding
                        border border-solid border-gray-300
                        rounded
                        transition
                        ease-in-out
                        mb-1
                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    >
                    <input v-model="contact.phone" class="form-control
                        w-1/4
                        px-2
                        py-1
                        text-sm
                        font-normal
                        text-gray-700
                        bg-white bg-clip-padding
                        border border-solid border-gray-300
                        rounded
                        transition
                        ease-in-out
                        mb-1
                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    >
                    <button type="button" @click="update(contact)" class="place-items-stretch inline-block mx-7 px-2 py-1 bg-sky-600 text-white font-medium text-sm leading-snug rounded shadow-md hover:bg-sky-700 hover:shadow-lg focus:bg-sky-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-sky-800 active:shadow-lg transition duration-150 ease-in-out">Update Contact</button>
                    <button type="button" @click="destroy(contact)" class="place-items-stretch inline-block mx-2 px-2 py-1 bg-red-600 text-white font-medium text-sm leading-snug rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Delete Contact</button>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },

    data () {
        return {
            contactForm: {
                name: '',
                email: '',
                phone: '',
                errors: {
                    name: '',
                    email: '',
                    phone: ''
                }
            },

            contacts: [],
        };
    },

    methods: {
        countClick () {
            axios.get('/count-click');
        },

        clearContact () {
            this.contactForm = {
                name: '',
                email: '',
                phone: '',
                errors: {
                    name: '',
                    email: '',
                    phone: '',
                },
            };
        },

        async saveContact () {
            try {
                let response = axios.post('/contacts', this.contactForm);
                let contact = (await response).data?.contact;
                if (contact !== null) {
                    this.contacts.push(contact);
                }
                this.clearContact();
            } catch (error) {
                console.log('create contact error: ', JSON.stringify(error.response.data));
                this.contactForm.errors.name = error.response?.data?.errors?.name? error.response.data.errors.name[0] : '';
                this.contactForm.errors.phone = error.response?.data?.errors?.phone? error.response.data.errors.phone[0] : '';
                this.contactForm.errors.email = error.response?.data?.errors?.email? error.response.data.errors.email[0] : '';
            }
        },

        update (contact) {
            console.log('contact', contact);
            axios.put(`/contacts/${contact.id}`, contact);
        },

        async destroy (contact) {
            try {
                let response = axios.delete(`/contacts/${contact.id}`);
                let success = (await response).data?.success;
                if (success) {
                    let i = this.contacts.map(item => item.id).indexOf(contact.id);
                    if (i !== -1) {
                        this.contacts.splice(i, 1);
                    }
                }
            } catch (error) {
                console.log('delete contact error: ', JSON.stringify(error.response.data));
            }
        },

        async getContacts () {
            try {
                let response = axios.get('/contacts');
                this.contacts = (await response).data?.contacts;
            } catch (error) {
                console.log('load contacts error: ', JSON.stringify(error.response.data));
                this.contacts = [];
            }
        },

        downloadCsv () {
            window.open('/download-contacts-csv', '_blank');
        },
    },

    created() {
        this.getContacts();
    }
}
</script>
