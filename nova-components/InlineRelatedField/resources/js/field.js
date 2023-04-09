import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-inline-related-field', IndexField)
  app.component('detail-inline-related-field', DetailField)
  app.component('form-inline-related-field', FormField)
})
