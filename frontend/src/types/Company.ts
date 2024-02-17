import { Customer } from "./Customer";
import { User } from "./User";
import { Team } from "./team";

export type Company = {
  id?: Number;
  name?: String;
  email?: String;
  balance?: Number;
  created_at?: Date;
  updated_at?: Date;
  customers?: Array<Customer>;
  teams?: Array<Team>;
  users?: Array<User>;
};
