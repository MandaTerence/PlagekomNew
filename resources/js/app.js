require('./bootstrap')
import {createApp} from 'vue'
import App from './App.vue'
import axios from 'axios'
import router from './router'
import { MonthPicker,MonthPickerInput } from 'vue-month-picker'
import { Line } from 'vue-chartjs'

const app = createApp(App)
app.config.globalProperties.$axios = axios;
app.config.globalProperties.$router = router;
app.use(router)
app.use(Line)
app.use(MonthPickerInput)
app.use(MonthPicker)
app.mount('#app')

