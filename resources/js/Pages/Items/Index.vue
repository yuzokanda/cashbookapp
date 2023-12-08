<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref, onMounted, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useStore } from 'vuex';

const props = defineProps({
    periods: {
        type: Object,
        default: () => ({}),
    },
    category_id: {
        type: Object,
        default: () => ({}),
    },
});

let categories = ref(props.category_id);
let selectedCategory = ref('');

const form = useForm({});

const store = useStore();

let items = ref([]);

// 現在の年月日時を取得
const now = new Date();
// 現在の年を取得
const year = now.getFullYear();
// 現在の月を取得
const month = now.getMonth() + 1;
// 現在年月をYYYY-MMの形式で取得
const yearMonth = `${year}-${month.toString().padStart(2, '0')}`;

// 選択年月は、状況により取るべき値が変わるように設定
let selectedPeriod = ref(store.state.selectedPeriod || props.periods[0] || yearMonth);

// 選択年月が存在する場合、年月のハイフンを削除し、年と月に分ける
const parts = computed(() => {
    return selectedPeriod.value ? selectedPeriod.value.split('-') : [];
});
// 分離処理された年の値の変化を監視
const selectYear = computed(() => {
    return parts.value[0];
});
// 分離処理された月を整数値の変換し、値の変化を監視
const selectMonth = computed(() => {
    return parseInt(parts.value[1]);
});
// 日本語表示形式(⚪︎年⚪︎月)に処理された値の変化を監視
const formattedPeriod = computed(() => {
    return `${selectYear.value}年${selectMonth.value}月`;
});

// 選択したカテゴリーのitemを支出日降順にソート
const filteredItems = computed(() => {
    let filtered = items.value;
    if (selectedCategory.value) {
        filtered = items.value.filter(item => item.category.id === selectedCategory.value);
    }
    return filtered.sort((a, b) => new Date(b.date) - new Date(a.date));
});
// 支出合計金額を算出
const amountTotal = computed(() => {
    return filteredItems.value.reduce((sum, item) => sum + (item.amount || 0), 0);
});
// fetchにより非同期に選択月のitemsをtry,catchのエラー処理をしつつ取得
const fetchData = async () => {
    try {
        const response = await fetch(`/items/${store.state.selectedPeriod}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        items.value = await response.json();
    } catch (error) {
        console.error('An error occurred while fetching the data: ', error);
    }
};

// DOMマウント直後にif条件分岐でfetchData()を実行
onMounted(() => {
    if (!store.state.selectedPeriod) {
    store.dispatch('updateSelectedPeriod', props.periods[0]);
    }
    fetchData();
});
// 年月の再選択によりselectedPeriodのstate変更
const changePeriod = async (period) => {
    await store.dispatch('updateSelectedPeriod', period);
    fetchData();
};

const deleteItem = (id) => {
    if (confirm("本当に削除しますか？")) {
        form.delete(route('items.destroy', id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => fetchData(),
        });
    };
};
</script>

<template>
    <Head title="INDEX ITEMS" />

    <AuthenticatedLayout>
        <template #header>
            <div class="text-xm font-semibold uppercase leading-tight text-gray-800">
                index items
            </div>
            <div v-if="$page.props.flash.message" class="bg-gray-400 text-white text-center">
                {{ $page.props.flash.message }}
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between ... mb-2 overflow-x-auto">
                            <div class="px-2">
                                <Link :href="route('items.create')">
                                <PrimaryButton class="bg-green-700">Add Item</PrimaryButton>
                                </Link>
                            </div>
                            <div class="px-2 py-2 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                {{ formattedPeriod }}支出合計 &yen; {{ amountTotal.toLocaleString() }}
                            </div>
                            <div class="px-2">
                                <Link :href="route('items.index')">
                                <PrimaryButton class="bg-yellow-500">
                                    All Category
                                </PrimaryButton>
                                </Link>
                            </div>
                            <div class="px-2">
                                <div>
                                    <select v-model="selectedCategory">
                                        <option selected disabled value="">カテゴリー別合計</option>
                                        <option v-for="category in categories" :key="category" :value="category.id">
                                            {{ category.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="px-2">
                                <div>
                                    <select v-model.lazy="selectedPeriod" @change="changePeriod (selectedPeriod)">
                                        <option v-for="period in periods" :key="period" :value="period">{{ period }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Content
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Amount
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Category
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Edit
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Delete
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in filteredItems" :key="item.id"
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white  whitespace-nowrap">
                                            {{ item.content }}
                                        </th>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white  whitespace-nowrap">
                                            &yen; {{ item.amount.toLocaleString() }}
                                        </th>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white  whitespace-nowrap">
                                            {{ item.category.name }}
                                        </th>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white  whitespace-nowrap">
                                            {{ item.date }}
                                        </th>
                                        <td class="px-6 py-4">
                                            <Link :href="route('items.edit', item.id)" class="px-4 py-2 text-white bg-blue-600 rounded-lg">Edit</Link>
                                        </td>
                                        <td class="px-6 py-4">
                                            <PrimaryButton class="bg-red-700" @click="deleteItem(item.id)">
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
