import default_state from "./meta/default_state";
import queries_state from "./meta/queries_state";
import contacts_state from "@/Store/State/contacts_state";
import settings_state from "@/Store/State/settings_state";
import groups_state from "@/Store/State/groups_state";
import gateways_state from "@/Store/State/gateways_state";
import message_state from "@/Store/State/message_state";
import reports_state from "@/Store/State/reports_state";
import stats_state from "@/Store/State/stats_state";

export default {
    ...default_state,
    ...queries_state,
    ...contacts_state,
    ...settings_state,
    ...groups_state,
    ...gateways_state,
    ...message_state,
    ...reports_state,
    ...stats_state
}
