import { Company } from "./Company";
import { Demand } from "./Demand";
import { User } from "./User";

export type Team = {
  id?: Number;
  description?: String;
  name?: String;
  company?: Company;
  demands?: Array<Demand>;
  users?: Array<User>;
};
