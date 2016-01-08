-- Table: changes_comment

-- DROP TABLE changes_comment;

CREATE TABLE changes_comment
(
  change_id integer[] NOT NULL,
  user_id character varying(64)[] NOT NULL,
  is_approver boolean,
  comment text NOT NULL,
  date_created time without time zone
)
WITH (
  OIDS=FALSE
);
ALTER TABLE changes_comment
  OWNER TO coca_admin;
