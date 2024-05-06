import axios from 'axios'
import { defineStore } from 'pinia'
import { useConfirm } from 'primevue/useconfirm';
import { useToast } from 'primevue/usetoast'
import { useBarangStore } from './barang';
import { usePelangganStore } from './pelanggan';
import moment from 'moment';

export const useMainStore = defineStore('main', {
	state: () => ({
		dataNum:0,
		randomDataArr: {
			pelanggan:'',
			barang:[]
		},
		randomDataTableLoading:false,
		loadingSimpan: false,
		queryNum:1,
		tableData:[],
        loadingData: false,
        queryParams:{
            first: 0,
			rows: 10,
			page: 0,
		},
        confirm: useConfirm(),
		toast: useToast(),
		chartData:{},
		chartOptions:{},
		sizeChartData:{},
	}),
	getters: {
		avgNormal: (state) => {
			let total = 0
			state.tableData.forEach((e) => {
				total += e.normal
			})
			return total/state.queryNum
		},
		avgIndex: (state) => {
			let total = 0
			state.tableData.forEach((e) => {
				total += e.dataIndex
			})
			return total/state.queryNum
		},
		avgJson: (state) => {
			let total = 0
			state.tableData.forEach((e) => {
				total += e.dataJson
			})
			return total/state.queryNum
		},
		avgCache: (state) => {
			let total = 0
			state.tableData.forEach((e) => {
				total += e.dataCache
			})
			return total/state.queryNum
		},
	},
	actions: {
		generateData(){
			this.randomDataTableLoading = true
			let BarangStore = useBarangStore()
			let PelangganStore = usePelangganStore()
			let randomPelanggan = PelangganStore.pelangganIndex[Math.floor(Math.random() * PelangganStore.pelangganIndex.length)]
			this.randomDataArr = {
				pelanggan:randomPelanggan,
				barang:[]
			}
			for(let i=0; i<this.dataNum; i++){
				let randomBarang = BarangStore.barangIndex[Math.floor(Math.random() * BarangStore.barangIndex.length)]
				let qty = Math.floor(Math.random() * 10) + 1
				this.randomDataArr.barang.push({barang:randomBarang,qty:qty})
			}
			this.randomDataTableLoading = false
		},
        async getDatatable(){
            this.loadingData = true
			this.tableData = []
			for(let i=0; i<this.queryNum; i++){
				this.tableData.push({normal:0,dataIndex:0,dataJson:0, dataCache:0, key:i})
				let res = await axios.get(`/api/detail-transaksi-index/get-data`,{
					params:{
						q: this.queryParams
					}
				})
				if(res.data.status){
					this.tableData[i].dataIndex = res.data.time
				}
				res = await axios.get(`/api/detail-transaksi/get-data`,{
					params:{
						q: this.queryParams
					}
				})
				if(res.data.status){
					this.tableData[i].normal = res.data.time
				}
				
				res = await axios.get(`/api/detail-transaksi-json/get-data`,{
					params:{
						q: this.queryParams
					}
				})
				if(res.data.status){
					this.tableData[i].dataJson = res.data.time
				}

				res = await axios.get(`/api/detail-transaksi-cache/get-data`,{
					params:{
						q: this.queryParams
					}
				})
				if(res.data.status){
					this.tableData[i].dataCache = res.data.time
				}
			}
			this.chartData = {
				labels: ['Normal', 'Indexed', 'JSON', 'Cache'],
				datasets:[{
					label: 'Rata - Rata Waktu',
					data: [this.avgNormal, this.avgIndex, this.avgJson, this.avgCache],
					backgroundColor: ['rgba(249, 115, 22, 0.2)', 'rgba(6, 182, 212, 0.2)', 'rgb(107, 114, 128, 0.2)', 'rgba(139, 92, 246 0.2)'],
					borderColor: ['rgb(249, 115, 22)', 'rgb(6, 182, 212)', 'rgb(107, 114, 128)', 'rgb(139, 92, 246)'],
					borderWidth: 1
				}]
			}
			this.chartOptions = this.setChartOption()
			this.loadingData = false
        },
        async simpan(){
			this.loadingSimpan = true
			const today = moment().format('YYYY-MM-DD');
			const formData = new FormData()
			formData.append('pelanggan_id', this.randomDataArr.pelanggan.id)
			formData.append('tanggal', today)
			formData.append('barang', JSON.stringify(this.randomDataArr))

			await axios.post(`/api/detail-transaksi/store-data`, formData).then((res) => {
				if(res.data.status){
					this.toast.add({ severity: 'info', summary: res.data.message, detail: 'Berhasil menyimpan data', life: 3000 });
				}
				else{
					this.toast.add({ severity: 'error', summary: 'Error', detail: 'Terjadi Kesalahan', life: 3000 });
				}
			})
			await axios.post(`/api/detail-transaksi-index/store-data`, formData).then((res) => {
				if(res.data.status){
					this.toast.add({ severity: 'info', summary: res.data.message, detail: 'Berhasil menyimpan data Index', life: 3000 });
				}
				else{
					this.toast.add({ severity: 'error', summary: 'Error', detail: 'Terjadi Kesalahan', life: 3000 });
				}
			})
			await axios.post(`/api/detail-transaksi-json/store-data`, formData).then((res) => {
				if(res.data.status){
					this.toast.add({ severity: 'info', summary: res.data.message, detail: 'Berhasil menyimpan data JSON', life: 3000 });
				}
				else{
					this.toast.add({ severity: 'error', summary: 'Error', detail: 'Terjadi Kesalahan', life: 3000 });
				}
			})
			this.loadingSimpan = false
			
		},
		test(){
			console.log(this.queryParams)
		},
		setChartOption(){
			const documentStyle = getComputedStyle(document.documentElement);
			const textColor = documentStyle.getPropertyValue('--text-color');
			const textColorSecondary = documentStyle.getPropertyValue('--text-color-secondary');
			const surfaceBorder = documentStyle.getPropertyValue('--surface-border');

			return {
				plugins: {
					legend: {
						labels: {
							color: textColor
						}
					}
				},
				scales: {
					x: {
						ticks: {
							color: textColorSecondary
						},
						grid: {
							color: surfaceBorder
						}
					},
					y: {
						beginAtZero: true,
						ticks: {
							color: textColorSecondary
						},
						grid: {
							color: surfaceBorder
						}
					}
				}
			};
		},
		async getTableSize(){
			const res = await axios.get(`/api/master/get-table-size`,{
				params:{
					q: this.queryParams
				}
			})
			if(res.data.status){
				let data = res.data.data
				this.sizeChartData = {
					labels: ['Normal', 'Indexed', 'JSON'],
					datasets:[{
						label: 'Besar Penyimpanan (bytes)',
						data: [data.normal, data.index, data.json],
						backgroundColor: ['rgba(249, 115, 22, 0.2)', 'rgba(6, 182, 212, 0.2)', 'rgb(107, 114, 128, 0.2)',],
						borderColor: ['rgb(249, 115, 22)', 'rgb(6, 182, 212)', 'rgb(107, 114, 128)',],
						borderWidth: 1
					}]
				}
			}
		}
	}
})