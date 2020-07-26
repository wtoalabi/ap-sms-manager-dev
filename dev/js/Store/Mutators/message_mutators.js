export default {
  toggle_message_sent(state,payload=false){
    state.messages.sent = payload
  }
}
