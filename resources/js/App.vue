<template>
    <Navbar/>
    <div class="min-h-screen bg-gray-100 pt-4">
        <router-view />
    </div>
    <ConfirmDialog></ConfirmDialog>
    <Toast></Toast>
</template>
<script setup>
import {useMainStore} from './store/main'
import { storeToRefs } from 'pinia'
import { onMounted } from 'vue';
import Navbar from './components/global/navbar.vue'

const MainStore = useMainStore()  
const{
    item, totalItems, queryParams,loadingData
} = storeToRefs(MainStore)

onMounted(() => {
    MainStore.test()
})

</script>