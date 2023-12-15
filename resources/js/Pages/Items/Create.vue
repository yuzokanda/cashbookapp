<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps({
    category_id: {
        type: Object,
        default: () => ({}),
    },
});

const form = reactive(useForm({
    content: "",
    amount: "",
    category_id: "",
    date: "",
}));

// const submitButton = ref(null);

// const submit = () => {
//   // disabled属性を削除する
//     submitButton.value.removeAttribute('disabled');

//   // submitメソッドを再実行する
//     form.post(route('items.store'), {
//         preserveState: true,
//     });

//   // submitボタンを無効化する
//     submitButton.value.setAttribute('disabled', 'disabled');
// };

// onMounted(() => {
//     submitButton.value = document.querySelector('button[type="submit"]');
// });
const submit = () => {
    form.post(route('items.store'), {
        preserveState: true,
    });
};

</script>

<template>
    <Head title="CREATE ITEM" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xm uppercase text-gray-800 leading-tight">create item</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-3xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg flex justify-center ...">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="content" value="content" />

                                <TextInput
                                    id="content"
                                    type="text"
                                    class="mt-1 block w-96"
                                    v-model="form.content"
                                    autofocus
                                    required
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
                                    class="mt-1 block w-32"
                                    v-model="form.amount"
                                    required
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.amount"
                                />
                            </div>
                            <div>
                                <InputLabel for="category_id" value="category" />

                                <select id="category_id" class="mt-1 block w-40" v-model="form.category_id" required>
                                    <option v-for="category in category_id" :key="category" :value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.category_id"
                                />
                            </div>
                            <div>
                                <InputLabel for="date" value="date" />

                                <TextInput
                                    id="date"
                                    type="date"
                                    class="mt-1 block w-40"
                                    v-model="form.date"
                                    required
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.date"
                                />
                            </div>

                            <div class="flex gap-4">
                                <div>
                                    <PrimaryButton
                                        type="submit"
                                        class="mt-4"
                                        :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing"
                                    >
                                        Add
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
