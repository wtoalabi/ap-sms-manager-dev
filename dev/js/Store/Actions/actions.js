import contact_actions from './contact_actions'
import settings_actions from "@/Store/Actions/settings_actions";
import meta_actions from "@/Store/Actions/meta_actions";
import group_actions from "@/Store/Actions/group_actions";
import gateway_actions from "@/Store/Actions/gateway_actions";
import message_actions from "@/Store/Actions/message_actions";
import report_actions from "@/Store/Actions/report_actions";
export default {
  ...contact_actions,
  ...settings_actions,
  ...meta_actions,
  ...group_actions,
  ...gateway_actions,
  ...message_actions,
  ...report_actions
}
