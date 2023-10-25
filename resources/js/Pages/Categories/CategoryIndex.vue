<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref, onMounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    categories: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({});

// const store = useStore();

let categories = ref([]);

onMounted(() => {
    categories.value = props.categories;
});

const deleteCategory = (id) => {
    if (confirm("本当に削除しますか？")) {
        form.delete(route("categories.destroy", id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => location.reload(),
        });
    };
};
</script>

<template>
    <Head title="Categories" />

    <AuthenticatedLayout>
        <template #header>
            <div class="text-xm font-semibold uppercase leading-tight text-gray-800">
                CATEGORIES
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between ... mb-2">
                            <div class="px-2">
                                <Link :href="route('categories.create')">
                                <PrimaryButton class="bg-green-700">Add Category</PrimaryButton>
                                </Link>
                            </div>
                        </div>

                        <!-- ここにカテゴリ一覧を表示 -->
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Delete
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="category in categories" :key="category.id"
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white  whitespace-nowrap">
                                            {{ category.name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            <PrimaryButton class="bg-red-700" @click="deleteCategory(category.id)">
                                                Delete
                                            </PrimaryButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
