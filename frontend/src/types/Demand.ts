import { Customer } from "./Customer";
import { Task } from "./Task";
import { Team } from "./team";

export type Demand = {
    id?: Number;
    title?: String;
    description?: String;
    status?: String;
    deadline?: Date;
    customer?: Customer;
    teams?: Array<Team>;
    tasks?: Array<Task>;

    open?: boolean;
}