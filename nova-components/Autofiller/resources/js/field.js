import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-autofiller', IndexField)
  app.component('detail-autofiller', DetailField)
  app.component('form-autofiller', FormField)
})
