<template>
  <div>
    <v-row>
      <v-col>
        <v-dialog
            :disabled="disabled"
            ref="date"
            v-model="date_dialog"
            :return-value.sync="date"
            persistent
            width="290px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
                :hint="hintMessage"
                persistent-hint
                :disabled="disabled"
                v-model="date"
                label="Schedule date of delivery"
                prepend-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
            ></v-text-field>
          </template>
          <v-date-picker v-model="date" :disabled="disabled">
            <v-spacer></v-spacer>
            <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
            <v-btn text color="primary" @click="setDate">OK</v-btn>
          </v-date-picker>
        </v-dialog>
      </v-col>
      <v-col>
        <v-dialog
            :disabled="disabled"
            ref="time"
            v-model="time_dialog"
            :return-value.sync="time"
            persistent
            width="290px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
                :disabled="disabled"
                v-model="time"
                label="Schedule exact time"
                prepend-icon="mdi-clock-outline"
                readonly
                v-bind="attrs"
                v-on="on"
            ></v-text-field>
          </template>
          <v-time-picker
              :disabled="disabled"
              v-if="time_dialog"
              v-model="time"
              full-width
          >
            <v-spacer></v-spacer>
            <v-btn text color="primary" @click="time_dialog = false">Cancel</v-btn>
            <v-btn text color="primary" @click="setTime">OK</v-btn>
          </v-time-picker>
        </v-dialog>
      </v-col>
    </v-row>
  </div>
</template>

<script>
  export default {
    props: ['disabled'],
    data() {
      return {
        date: "",
        time: "",
        date_dialog: false,
        time_dialog: false,
      }
    },
    methods: {
      setTime(){
        this.$refs.time.save(this.time)
        this.sendDateTime()
      },
      setDate(){
        this.$refs.date.save(this.date)
        this.sendDateTime()
      },
      sendDateTime(){
        let dateTime = new Date(`${this.date} ${this.time}`);
        let timestamp = Date.parse(`${dateTime}`)
        this.$emit("date_time", timestamp)
      }
    },
    computed: {
      hintMessage() {
        if (this.disabled) {
          return "The selected gateway api does not support delivery scheduling..."
        }else{
          return "Format: YYYY/MM/DD"
        }
      }
    }
  }

</script>
