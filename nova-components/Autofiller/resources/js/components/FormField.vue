<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
    <template #field>
      
      <select style="
    width: 100%;
    m
    height: 35px;
    padding: 4px;
    background: #171737;
" v-model="selected" @change="onChange($event)">
  <option v-for="option in field.modelworld" :value="option.id" type="select">
    {{ option.headline }}
  </option>
</select>
      
    </template>
  </DefaultField>
  
      


</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {

  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data() {
    return {
      maxLength: 255,
      theGist: document.getElementById('headline'),
      selected: 'A',
      options: [
        { text: 'One', value: 'A' },
        { text: 'Two', value: 'B' },
        { text: 'Three', value: 'C' }
      ]
    }


  },

  mounted() {
      
    console.log("Do you see?");
    

    
  
    },

  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || ''
    },
    

    onChange(event) {
      console.log("I'm here!! OnChange event is a go");
      Nova.$emit(
    this.getFieldAttributeValueEventName('email_body'), // the name of the event is randomised on every page load, that's why you need to use this function to determine it.
    'Email body on my mind!'
);
      //const found = this.field.modelworld.find(element => id = event.target.value);
      console.log(this.field.modelworld[3]);
      console.log('The player is about to begin');
      console.log(this.field.player);
      console.log("About to create an attributor... let's see if it hears it");
      console.log(this.field.player[0]['company_permalink']);
      console.log("The S3 url is here and we are in a game of wits");
      console.log(this.field.player[0]['company_logo']);
      let attributer = [
    {
        "uniqueKey": "title-default-text-field",
        "component": "text-field",
        "attribute": "title",
        "dependentComponentKey": "text.text-field.title",
        "indexName": "Title",
        "name": "Title",
        "sortableUriKey": "title",
        "stacked": false,
        "textAlign": "left",
        "usesCustomizedDisplay": false,
        "value": "avatar_0",
        "visible": true
    },
    {
        "uniqueKey": "name-default-text-field",
        "component": "text-field",
        "attribute": "name",
        "dependentComponentKey": "text.text-field.name",
        "indexName": "Name",
        "name": "Name",
        "sortableUriKey": "name",
        "stacked": false,
        "textAlign": "left",
        "usesCustomizedDisplay": false,
        "value": "text",
        "visible": true
    },
    {
        "uniqueKey": "property-default-textarea-field",
        "component": "textarea-field",
        "attribute": "property",
        "dependentComponentKey": "textarea.textarea-field.property",
        "indexName": "Property",
        "name": "Property",
        "sortableUriKey": "property",
        "stacked": false,
        "textAlign": "left",
        "usesCustomizedDisplay": false,
        "value": "99 problems and a row ain't one",
        "visible": true
    }
];
console.log("The event target value is: ");
console.log(event.target.value);
let number = Number(event.target.value);
console.log("The whole enchilada is: ");
console.log(this.field.modelworld);
var index = this.field.modelworld.map(function(o) { return o.id; }).indexOf(number);
console.log("The index of the select is: ");
console.log(index);
      Nova.$emit('group-adderol', this.field.modelworld[index], this.field.player);
      

      for(const pos in this.field.modelworld) {
        if(this.field.modelworld[pos]['id'] == event.target.value) {
          console.log("The real sacred egg is as so: ");
          console.log(this.field.modelworld[pos]);
    
          for (const key in this.field.modelworld[pos]) {
          let value = this.field.modelworld[pos][key];

          

          if(key =='copy' || key == 'mms_msg') { 
            value = value.replaceAll("{{company_name}}", this.field.player[0]['company_name']);
            //console.log("Do you see some truth?", copy_val);
            console.log('THE VALUE OF OUR FOREFATHERS: of which the key is ' + key + ' and the company name from player is: ' + this.field.player[0]['company_name'] + 'is the following value: ' + value);
            //let selector = '[dusk="video_script"]'; let bigBoy = document.querySelectorAll(selector); bigBoy[0].value = copy_val; 
          }
          if(key == 'copy') {
            Nova.$emit(
    this.getFieldAttributeValueEventName('copy'), // the name of the event is randomised on every page load, that's why you need to use this function to determine it.
    value
);
          }
          if(key != 'id' && key != 'template_null' && key != 'email_body' && key != 'created_at' && key != 'copy' && key != 'updated_at' && key != 'mms_image' && key != 'cooked' && key != 'campaign_ready' && key != 'created_at' && key != 'author_id' && key != 'template') {
          let selector = '[dusk="' + key + '"]';
          /*console.log('Selector is: ' + selector);

          let bigBoy = document.querySelectorAll(selector);
          bigBoy[0].value = value;
          console.log("Commas are interesting");
          console.log(key, value); */

          Nova.$emit(
    this.getFieldAttributeValueEventName(key), // the name of the event is randomised on every page load, that's why you need to use this function to determine it.
    value
);
        
        
        }

       
      }
        }
      }




      console.log('Do you see a heartbeat?');
      /*
      let bigBoy = document.querySelectorAll('[dusk="tiktok_url"]');
      bigBoy[0].value = event.target.value;
      for (const property in this.field.modelworld[event.target.value]['value']) {
        console.log(`${property}: ${this.field.modelworld[event.target.value]['value'][property]}`);
        let selector = '[dusk="' + property + '"]'; //concat('[dusk="', 'subheadline"]');
        let bigBoy = document.querySelectorAll(selector);
        bigBoy[0].value = this.field.selector[event.target.value]['value'][property];
      }
      console.log('TikTok is: ' + this.field.selector[event.target.value]['value']['tiktok_url']);*/


    },
    gist(field) {
      //let bigBoy = document.querySelectorAll('[dusk="tiktok_url"]');
      //bigBoy[0].value = 'New ish exclusive';
      //console.log(bigBoy[0]._value);
      //this.field.objects.foreach(value => { console.log('Do you hear a value calling?'); });
      //for(var key in Object.keys(this.field)) {
        //console.log(Object.keys(this.field)[key].value);
        //console.log('The key is: ' + key);
        for(var key1 in this.field.selector) {
          for(var key2 in this.field.selector[key1]) {
             console.log('Value is ' + this.field.selector[key1][key2]);
          }
        }
        //console.log(this.field.collector[0]['name']);
      },

    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      console.log("The appender is :");
      console.log(this.field.attribute);
      console.log(this.value);
      //formData.append('subheadline', 'Nothing' || '');
      formData.append('Nothing', 'Faggedaboutit');
    },
  }

</script>
