import { Company } from "./Company";
import { Team } from "./team";

export type User = {
    id?: Number;
    first_name?: String;
    last_name?: String;
    email?: String;
    full_name?: String;
    company?: Company;
    teams?: Array<Team>;
}