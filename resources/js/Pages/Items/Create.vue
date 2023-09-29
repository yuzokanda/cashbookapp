<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
        items: {
            type: Object,
            default: () => ({}),
        },
    });

const form = useForm({
    content: "",
    amount: "",
    category: "",
    date: "",
});

const submit = () =>  {
    form.post(route("items.store"));
};

</script>

<template>
    <Head title="Item Create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xm uppercase text-gray-800 leading-tight">Item Create</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="content" value="content" />

                                <TextInput
                                    id="content"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.content"
                                    required
                                    autofocus
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.content"
                                />
                            </div>
                            <div>
                                <InputLabel for="amount" value="amount" />

                                <TextInput
                                    id="amount"
                                    type="number"
                                    class="mt-1 block w-full"
                                    v-model="form.amount"
                                    required
                                    autofocus
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.amount"
                                />
                            </div>
                            <div>
                                <InputLabel for="category" value="category" />

                                <TextInput
                                    id="category"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.category"
                                    required
                                    autofocus
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.category"
                                />
                            </div>
                            <div>
                                <InputLabel for="date" value="date" />

                                <TextInput
                                    id="date"
                                    type="date"
                                    class="mt-1 block w-full"
                                    v-model="form.date"
                                    required
                                    autofocus
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.date"
                                />
                            </div>

                            <PrimaryButton
                                type="submit"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Submit
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
