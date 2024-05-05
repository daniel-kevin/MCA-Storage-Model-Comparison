import axios from 'axios'
import { defineStore } from 'pinia'

export const usePelangganStore = defineStore('pelanggan', {
	state: () => ({
        pelangganIndex:'',
		pelanggan:'',
        loadingDataPelanggan: false,
	}),
	getters: {},
	actions: {
		async getData() {
            this.loadingDataPelanggan = true
            await axios.get(`/api/pelanggan-index/get-data`).then((res) => {
                if(res.data.status){
                    this.pelangganIndex = res.data.data
                    console.log(this.pelangganIndex)
                }
                this.loadingDataPelanggan = false
            })
		},
	}
})