<template>
  <div>
    <v-textarea
        v-model="contacts"
        filled
        outlined
        autogrow
        color="primary"
        label="[OPTIONAL] You can also manually add numbers in addition to the group above. One per line."
        rows="2"
        @input="added"
        :hint="errorMessage"
        :background-color="bgColor"
        persistent-hint
    ></v-textarea>
  </div>
</template>

<script>
  export default {
    mounted() {
      if(aps_globals._.isNotEmpty(this.selectedContacts)){
        this.addSelectedContacts()
      }
    },
    data() {
      return {
        hasError: false,
        errorMessage: null,
        contacts: [],
        processed: []
      }
    },
    methods: {
      added(numbers) {
        this.errorMessage = null
        this.processed = this.process(numbers)
        this.$emit("added", {"numbers": this.processed, "hasError": this.hasError})
      },
      process(numbers) {
        if (numbers) {
          let arr = numbers.split("\n");
          if (arr.every(each => aps_globals._.isPhoneNumber(each))) {
            this.hasError = false
            return arr;
          } else {
            this.hasError = true
            this.errorMessage = "Make sure all the input numbers are in the right format, like so: +2118163684917"
          }
        } else {
          this.hasError = false
        }
      },
      addSelectedContacts(){
        let contacts = "";
        let numbers = this.selectedContacts.map(contact=> contact.number)
        for (let i = 0; i<numbers.length;i++){
            contacts += `${numbers[i]}`
          if(i+1 < numbers.length){
            contacts += '\n';
          }
        }
        this.contacts = contacts;
        this.processed = numbers;
        this.$emit("added", {"numbers": numbers, "hasError": this.hasError})
      },
    },
    computed: {
      selectedContacts(){
        return this.$store.state.contacts.selectedContacts;
      },
      bgColor() {
        return this.hasError ? "#FBE9E7" : "#F1F8E9"
      }
    }
  }

</script>
