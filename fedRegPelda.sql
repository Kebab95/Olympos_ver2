with email as (
	insert into data.email_data values (default,'clientTeszt@gmail.com') returning ed_id
),
telefon as (
	insert into data.telefon_data values (default, '+36301234567') returning td_id
),
userInsert as (
	insert into data.main_user values ( 
					default, 
					2, 
					(select ed_id from email), 
					(select td_id from telefon),
					'TesztValami',
					null,
					true,
					NOW(),
					NOW()
				)
				returning mu_id
),
perm as (
	insert into data.permission (p_mu_id,p_visitor) values (
		(select mu_id from userInsert),
		true
	)
),
postalAdd as (
	insert into data.postal_address_data values (
		default,
		1234,
		'Csomád',
		'valami utca'
	)
	returning pad_id
),
orgData as (
	insert into org.org_data values (
		default,
		(select mu_id from userInsert),
		'T',
		'asdasd',
		(select pad_id from postalAdd),
		null,
		'',
		'',
		'123123123'
	)
	returning org_id
),
fedLeader as (
	insert into org.federation_leader values (
		default,
		24,
		(select mu_id from userInsert)
	)
	returning fl_mu_id
)
update data.permission set p_federation_leader=true where p_mu_id=(select fl_mu_id from fedLeader);
