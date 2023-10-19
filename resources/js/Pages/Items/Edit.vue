<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
// import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    item: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    id: props.item.id,
    content: props.item.content,
    amount: props.item.amount,
    category: props.item.category,
    date: props.item.date,
});

const submit = () => {
    form.put(route("items.update", props.item.id));
};

</script>

<template>
    <Head title="ITEM EDIT" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xm font-semibold uppercase leading-tight text-gray-800">
                Item Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg flex justify-center ...">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="content" value="content" />

                                <TextInput id="content" type="text" class="mt-1 block w-96" v-model="form.content" required
                                    autofocus autocomplete="username" />

                                <InputError class="mt-2" :message="form.errors.content" />
                            </div>
                            <div>
                                <InputLabel for="amount" value="amount" />

                                <TextInput id="amount" type="number" class="mt-1 block w-32" v-model="form.amount" required autocomplete="username" />

                                <InputError class="mt-2" :message="form.errors.amount" />
                            </div>
                            <div>
                                <InputLabel for="category" value="category" />

                                <TextInput id="category" type="text" class="mt-1 block w-40" v-model="form.category" required autocomplete="username" />

                                <InputError class="mt-2" :message="form.errors.category" />
                            </div>
                            <div>
                                <InputLabel for="date" value="date" />

                                <TextInput id="date" type="date" class="mt-1 block w-40" v-model="form.date" required autocomplete="username" />

                                <InputError class="mt-2" :message="form.errors.date" />
                            </div>
                            <div class="flex gap-4">
                            <div>
                            <PrimaryButton type="submit" class="mt-4" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Submit
                            </PrimaryButton>
                            </div>
                            <!-- Indexページに戻るボタン追加 -->
                            <div>
                                <Link :href="route('items.index')">
                                <PrimaryButton class="mt-4 bg-violet-700">Return</PrimaryButton>
                            </Link>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
