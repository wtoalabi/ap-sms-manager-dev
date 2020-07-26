import loading_mutators from "./meta/loading_mutators";
import query_mutators from "./meta/query_mutators";
import contact_mutators from "@/Store/Mutators/contact_mutators";
import settings_mutators from "@/Store/Mutators/settings_mutators";
import group_mutators from "@/Store/Mutators/group_mutators";
import gateway_mutators from "@/Store/Mutators/gateway_mutators";
import message_mutators from "@/Store/Mutators/message_mutators";
import reports_mutators from "@/Store/Mutators/reports_mutators";
export default {
  ...loading_mutators,
  ...query_mutators,
  ...contact_mutators,
  ...settings_mutators,
  ...group_mutators,
  ...gateway_mutators,
  ...message_mutators,
  ...reports_mutators,
}
