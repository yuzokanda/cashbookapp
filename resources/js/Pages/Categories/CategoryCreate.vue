<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
});

const submit = () => {
    form.post(route('categories.store'), {
        preserveState: true,
    });
};
</script>

<template>
    <Head title="CREATE CATEGORY" />

    <AuthenticatedLayout>
        <template #header>
            <div class="text-xm font-semibold uppercase leading-tight text-gray-800">
                create category
            </div>
        </template>
        <!-- ここにカテゴリ作成フォームを表示 -->
        <div class="py-12">
            <div class="mx-auto max-w-3xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg flex justify-center ...">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="name" value="name" />

                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-96"
                                    v-model="form.name"
                                    required
                                    autofocus
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.name"
                                />
                            </div>
                            <div class="flex gap-4">
                                <div>
                                    <PrimaryButton
                                        type="submit"
                                        class="mt-4"
                                        :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing"
                                        @click="submit"
                                    >
                                        Add
                                    </PrimaryButton>
                                </div>
                                <!-- Indexページに戻るボタン追加 -->
                                <div>
                                    <Link :href="route('categories.index')">
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
