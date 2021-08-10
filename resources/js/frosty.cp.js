import FrostyFieldType from './components/fieldtypes/FrostyFieldType.vue'

Statamic.booting(() => {
    Statamic.component('frosty-fieldtype', FrostyFieldType)
})