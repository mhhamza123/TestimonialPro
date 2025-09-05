<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-500">
                    <div x-data="testimonialForm()" class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-200"> Add Testimonial </h3>
                        <div x-show="isSuccess" class="text-green-500">
                            <span x-text="message"></span>
                        </div>
                         <div x-show="isFailed" class="text-red-500">
                            <span x-text="message"></span>
                        </div>
                        <!-- Form -->
                        <form @submit.prevent="submitForm" enctype="multipart/form-data">
                            <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                                <div class="py-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                    <input type="text" x-model="form.name" class="mt-1 block w-full rounded-md hadow-sm" required>
                                </div>
                                <div class="py-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                    <select x-model="form.status" class="mt-1 block w-full rounded-md hadow-sm">
                                        <option value="">Select Status</option>
                                        @foreach (\App\Enums\TestimonialStatus::cases() as $ts)
                                            <option value="{{ $ts->value }}">{{ $ts->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="py-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                                    <input type="text" x-model="form.role" class="mt-1 block w-full rounded-md hadow-sm">
                                </div>
                                <div class="py-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image</label>
                                    <input type="file" @change="handleFileUpload" class="mt-1 block w-full text-gray-700 dark:text-gray-300 border border-gray-300 p-1 rounded">
                                </div>
                            </div>
                            <div class="py-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                                <textarea x-model="form.message" class="mt-1 block w-full rounded-md hadow-sm" rows="5" required></textarea>
                            </div>
                            <span x-show="isSaving">saving...</span>
                            <div class="py-2">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" x-text="form.id ? 'Update' : 'Submit'"></button>
                                <button type="button" @click="resetForm" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</button>
                            </div>
                        </form>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="py-2">Name</th>
                                        <th class="py-2">Message</th>
                                        <th class="py-2">Role</th>
                                        <th class="py-2">Image</th>
                                        <th class="py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="testimonial in testimonials" :key="testimonial.id">
                                        <tr class="border-b border-gray-200 dark:border-gray-700" :class="{ 'opacity-50': testimonial.status == '0' }">
                                            <td class="px-4 py-2" x-text="testimonial.name"></td>
                                            <td class="px-4 py-2" x-text="testimonial.message"></td>
                                            <td class="px-4 py-2" x-text="testimonial.role"></td>
                                            <td class="px-4 py-2">
                                                <template x-if="testimonial.image">
                                                    <img :src="testimonial.image" alt="" class="h-10 w-10 rounded-full object-cover">
                                                </template>
                                            </td>
                                            <td class="px-4 py-2 space-x-2 flex">
                                                <button @click="editTestimonial(testimonial)" class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</button>
                                                <button @click="deleteTestimonial(testimonial.id)" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <script>
                    function testimonialForm() {
                        return {
                            testimonials: [],
                            message: '',
                            isSaving: false,
                            isSuccess: false,
                            isFailed: false,
                            form: {
                                id: null,
                                name: '',
                                message: '',
                                status: 'pending',
                                role: '',
                                image: null,
                            },
                            fetchTestimonials() {
                                fetch('{{route('admin.testimonials.fetch')}}')
                                    .then(res => res.json())
                                    .then(data => this.testimonials = data);
                            },
                            handleFileUpload(e) {
                                this.form.image = e.target.files[0];
                            },
                            submitForm() {
                                this.isSaving = true;
                                let formData = new FormData();
                                formData.append('name', this.form.name);
                                formData.append('message', this.form.message);
                                formData.append('status', this.form.status);
                                formData.append('role', this.form.role);
                                if (this.form.image) formData.append('image', this.form.image);

                                let url = '{{route('admin.testimonials.save')}}';
                                let method = 'POST';

                                if (this.form.id) {
                                    url += '?id=' + this.form.id;
                                    formData.append('_method', 'POST');
                                }

                                fetch(url, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        'Accept': 'application/json',
                                    },
                                    body: formData
                                })
                                .then(res => res.json())
                                .then((res) => {
                                    if(res.errors) {
                                        this.message = Object.values(res.errors).flat().join("\n");
                                        this.isSuccess = false;
                                        this.isFailed = true;
                                    }
                                    else if(res.success) {
                                        this.message = res.message;
                                        this.isSuccess = true;
                                        this.isFailed = false;
                                        this.resetForm();
                                        this.fetchTestimonials();
                                    }
                                    else {
                                        this.message = 'Failed to save Testimonial.';
                                        this.isSuccess = false;
                                        this.isFailed = true;
                                    }
                                    this.isSaving = false;
                                });
                            },
                            editTestimonial(testimonial) {
                                this.form = {
                                    id: testimonial.id,
                                    name: testimonial.name,
                                    message: testimonial.message,
                                    status: testimonial.status,
                                    role: testimonial.role,
                                    image: null,
                                };
                            },
                            deleteTestimonial(id) {
                                if (!confirm('Are you sure?')) return;
                                fetch("{{route('admin.testimonials.delete')}}?id=" + id, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({ _method: 'DELETE' })
                                })
                                .then(() => this.fetchTestimonials());
                            },
                            resetForm() {
                                this.form = {
                                    id: null,
                                    name: '',
                                    message: '',
                                    status: 'pending',
                                    role: '',
                                    image: null,
                                };
                                document.querySelector('input[type="file"]').value = '';
                            },
                            init() {
                                this.fetchTestimonials();
                            }
                        }
                    }
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
