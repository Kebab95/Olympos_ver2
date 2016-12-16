with email as (
	select * from data."emailExistFoo(asd@asd)" as ed_id
),
telefon as (
	select * from data."telefonExistFoo(1234567)" as td_id
),
userInsert as (
	insert into data.main_user values (default,1,(select ed_id from email),(select td_id from telefon),'Name1',null,true,NOW(),NOW()) returning mu_id
       
)
insert into data.permission (p_mu_id,p_visitor) values ((select mu_id from userInsert),true);