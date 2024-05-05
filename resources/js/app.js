import './bootstrap';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import PiniaRouter from 'pinia-plugin-router';
import router from './router/index';
import App from './App.vue';
import '../css/app.css'

/**
 * 3rd Party Components
 */
import PrimeVue from 'primevue/config';

/**
 * PrimeVue
 */
import 'primevue/resources/primevue.min.css'
import 'primevue/resources/themes/lara-light-indigo/theme.css'
import AutoComplete from 'primevue/autocomplete';
import Dropdown from 'primevue/dropdown';
import Textarea from 'primevue/textarea';
import FloatLabel from 'primevue/floatlabel';
import InputNumber from 'primevue/inputnumber';
import Button from 'primevue/button';
import ButtonGroup from 'primevue/buttongroup';
import 'primeicons/primeicons.css'
import Calendar from 'primevue/calendar';
import InputText from 'primevue/inputtext';
import ProgressSpinner from 'primevue/progressspinner';
import ConfirmDialog from 'primevue/confirmdialog';
import ConfirmationService from 'primevue/confirmationservice'
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice'
import Menubar from 'primevue/menubar';


/**
 * PrimeVue Table
 */
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';  
import Row from 'primevue/row';  

const pinia = createPinia()
pinia.use(PiniaRouter(router));
const app = createApp(App)

app.component('AutoComplete',AutoComplete)
app.component('Dropdown',Dropdown)
app.component('Textarea',Textarea)
app.component('FloatLabel',FloatLabel)
app.component('InputNumber',InputNumber)
app.component('DataTable',DataTable)
app.component('Button',Button)
app.component('ButtonGroup',ButtonGroup)
app.component('Calendar',Calendar)
app.component('InputText',InputText)
app.component('ProgressSpinner',ProgressSpinner)
app.component('ConfirmDialog',ConfirmDialog)
app.component('Toast',Toast)
app.component('Column',Column)
app.component('ColumnGroup',ColumnGroup)
app.component('Row',Row)
app.component('Menubar',Menubar)

app.use(PrimeVue, {
    unstyled: false
});
app.use(ConfirmationService)
app.use(ToastService)
app.use(pinia)
app.use(router);
app.mount('#app')
