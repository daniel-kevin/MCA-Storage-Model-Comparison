
<template>
    <div class="sticky top-0 z-50">
        <Menubar :model="items" class="bg-white bg-opacity-75 backdrop-blur-lg"/>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from 'vue-router';

const router = useRouter();

const items = ref([
    {
        label: 'Home',
        icon: 'pi pi-home',
        command: () => {
            router.push('/spa/home')
        }
    },
    {
        label: 'About Us',
        icon: 'pi pi-user',
        command: () => {
            router.push('/spa/about-us')
        }
    },
]);
</script>
