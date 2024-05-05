import axios from 'axios'
import { defineStore } from 'pinia'

export const useBarangStore = defineStore('barang', {
	state: () => ({
        barangIndex:'',
		barang:'',
        loadingDataBarang: false,
	}),
	getters: {},
	actions: {
		async getData() {
            this.loadingDataBarang = true
            await axios.get(`/api/barang-index/get-data`).then((res) => {
                if(res.data.status){
                    this.barangIndex = res.data.data
                    console.log(this.barangIndex)
                }
                this.loadingDataBarang = false
            })
		},
	}
})