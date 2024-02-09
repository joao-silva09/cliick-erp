import { MessageTypeEnum } from "./Enums";

export type Message = {
  id?: string;
  message?: string;
  username?: string;
  message_type?: MessageTypeEnum;
  created_at?: Date;
};
