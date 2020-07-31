export default {
  toggle_message_is_sending(state,payload=false){
    state.messages.isSending = payload
  }
}
