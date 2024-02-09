import { Demand } from "./Demand";

export type Customer = {
  id?: Number;
  name?: String;
  email?: String;
  entry_date?: Date;
  demands?: Array<Demand>;
};
