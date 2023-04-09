import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-peektest', IndexField)
  app.component('detail-peektest', DetailField)
  app.component('form-peektest', FormField)
})
