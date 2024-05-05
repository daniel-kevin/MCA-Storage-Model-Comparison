<template>
    <div class="text-center">
        <h1 class="text-6xl text-indigo-700 font-bold">
            UTS MCA
        </h1>
        <div class="mt-2">
            Oleh :
        </div>
        <div class="mt-2">
            <h3 class="text-xl">
                Daniel Kevin Alexander - 2005551071
            </h3>
            <h3 class="text-xl">
                Ni Putu Meika Dharmayanti - 2105551017
            </h3>
        </div>
    </div>

    <div class="w-full mt-4 px-5 grid grid-cols-2 gap-2">
        <div>
            <div class="card shadow-md mb-3">
                <TabView>
                    <TabPanel header="Query">
                        <div>
                            <div>
                                Jumlah
                            </div>
                            <InputNumber v-model="queryNum" class="w-full mb-3" />
                            <Slider v-model="queryNum" :min="1" :max="30" class="w-full" />
                            <Button label="Query" class="mt-10" @click="MainStore.getDatatable()"/>
                        </div>
                    </TabPanel>
                    <TabPanel header="Generate Random Data">
                        <!-- <div class="font-semibold mb-4 text-lg">
                            Generate Random Data Transaksi
                        </div> -->
                        <div>
                            <div>
                                Jumlah
                            </div>
                            <InputNumber v-model="dataNum" class="w-full mb-3" />
                            <Slider v-model="dataNum" :min="0" :max="500" class="w-full" />
                            <Button label="Generate" class="mt-10 w-full" @click="MainStore.generateData()" :disabled="loadingDataBarang || loadingDataPelanggan"/>
                        </div>
                        <div class="mt-2">
                            <DataTable :value="randomDataArr.barang" dataKey="key" size="large" :loading="randomDataTableLoading" scrollable scrollHeight="400px">
                                <Column field="barang.nama" header="Barang"></Column>
                                <Column field="qty" header="Qty"></Column>
                                <template #empty>
                                    <div class="flex justify-center">
                                        Tidak Ada Data
                                    </div>
                                </template>
                                <template #loading>
                                    <div class="flex justify-center">
                                        <ProgressSpinner />
                                    </div>
                                </template>
                            </DataTable>
                        </div>
                        <div v-if="randomDataArr.barang.length > 0">
                            <Button label="Simpan" class="mt-10 w-full bg-green-500 hover:bg-green-700 border border-green-500" @click="MainStore.simpan()" :disabled="loadingSimpan"/>
                        </div>
                    </TabPanel>
                </TabView>
            </div>
        </div>
        <div>
            <div class="card shadow-md mb-3">
                <DataTable :value="tableData" stripedRows dataKey="key" size="small" :loading="loadingData" scrollable scrollHeight="400px">
                    <Column header="No.">
                        <template #body="slotProps">
                            {{ slotProps.data.key + 1 }}
                        </template>
                    </Column>
                    <Column field="normal" header="Normal"></Column>
                    <Column field="dataIndex" header="Table Indexed"></Column>
                    <Column field="dataJson" header="Table JSON"></Column>
                    <template #empty>
                        <div class="flex justify-center">
                            Tidak Ada Data
                        </div>
                    </template>
                    <template #loading>
                        <div class="flex justify-center">
                            <ProgressSpinner />
                        </div>
                    </template>
                    <ColumnGroup type="footer">
                            <Row>
                                <Column footer="Rata - Rata:" footerStyle="text-align:right"/>
                                <Column :footer="MainStore.avgNormal" />
                                <Column :footer="MainStore.avgIndex" />
                                <Column :footer="MainStore.avgJson" />
                            </Row>
                        </ColumnGroup>
                </DataTable>
            </div>
        </div>
        <div class="mt-4 rounded-md bg-white shadow-md mb-4 p-2">
            <Chart type="bar" :data="chartData" :options="chartOptions"/>
        </div>
        <div class="mt-4 rounded-md bg-white shadow-md mb-4 p-2">
            <Chart type="bar" :data="sizeChartData" :options="chartOptions"/>
        </div>
    </div>
</template>
<script setup>
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import Slider from 'primevue/slider';
import Chart from 'primevue/chart';

import { useMainStore } from '../../store/main'
import { useBarangStore } from '../../store/barang'
import { usePelangganStore } from '../../store/pelanggan'
import { storeToRefs } from 'pinia'
import { onMounted } from 'vue';

const MainStore = useMainStore()  
const BarangStore = useBarangStore()
const PelangganStore = usePelangganStore()

const{
    dataNum, randomDataArr, randomDataTableLoading, loadingSimpan, 
    queryNum,tableData, loadingData, chartData, chartOptions, sizeChartData
} = storeToRefs(MainStore)

const{
    loadingDataBarang
} = storeToRefs(BarangStore)

const{
    loadingDataPelanggan
} = storeToRefs(PelangganStore)

onMounted(() => {
    MainStore.getTableSize()
    BarangStore.getData()
    PelangganStore.getData()
})



</script>