<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
// import { ref } from 'vue';

const props = defineProps({
    items: Array
})

const deleteItem = (id) => {
    this.$inertia.delete(`/items/${id}`);
}
</script>

<template>
    <AuthenticatedLayout>
        <div>
            <h1>Items</h1>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Amount</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>スーパーで買い物</td>
                        <td>¥1,100</td>
                        <td>食費</td>
                        <td><button>編集</button></td>
                        <td><button>削除</button></td>
                    </tr>
                    <tr>
                        <td>映画鑑賞</td>
                        <td>¥1,900</td>
                        <td>レジャー</td>
                        <td><button>編集</button></td>
                        <td><button>削除</button></td>
                    </tr>
                    <!-- <tr v-for="item in items" :key="item.id">
                        <td>{{ item.item }}</td>
                        <td>{{ item.amount }}</td>
                        <td>{{ item.category }}</td>
                        <td><button @click="deleteItem(item.id)">Delete</button></td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>

<!-- <style>
.greeting {
    text-align: center;
    font-weight: bold;
}
</style> -->
