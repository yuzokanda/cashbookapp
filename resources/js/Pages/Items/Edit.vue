<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({
    item: {
        type: Object,
        default: () => ({}),
    },
});
console.log(props.item);

const form = useForm({
    id: props.item.id,
    content: props.item.content,
    amount: props.item.amount,
    category: props.item.category,
    date: props.item.date,
});
console.log('がががががが');
console.log(form.id);



const submit = () => {
    form.put(route("items.update", props.item.id));
};
</script>

<template>
    <Head title="Item Edit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xm font-semibold uppercase leading-tight text-gray-800">
                Blog Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="content" value="Content" />

                                <TextInput id="content" type="text" class="mt-1 block w-full" v-model="form.content" required
                                    autofocus autocomplete="username" />

                                <InputError class="mt-2" :message="form.errors.content" />
                            </div>
                            <div>
                                <InputLabel for="amount" value="Amount" />

                                <TextInput id="amount" type="number" class="mt-1 block w-full" v-model="form.amount" required
                                    autofocus autocomplete="username" />

                                <InputError class="mt-2" :message="form.errors.amount" />
                            </div>
                            <div>
                                <InputLabel for="category" value="Category" />

                                <TextInput id="category" type="text" class="mt-1 block w-full" v-model="form.category" required
                                    autofocus autocomplete="username" />

                                <InputError class="mt-2" :message="form.errors.category" />
                            </div>
                            <div>
                                <InputLabel for="date" value="Date" />

                                <TextInput id="date" type="date" class="mt-1 block w-full" v-model="form.date" required
                                    autofocus autocomplete="username" />

                                <InputError class="mt-2" :message="form.errors.date" />
                            </div>
                            <PrimaryButton type="submit" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Submit
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
