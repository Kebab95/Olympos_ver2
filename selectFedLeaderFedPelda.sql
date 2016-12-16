select * from data.main_user as mu

inner join data.email_data as email on
mu.mu_email_id=email.ed_id

inner join data.telefon_data as telefon on
mu.mu_telefon_id=telefon.td_id

inner join org.org_data as org on
mu.mu_id=org.org_mu_id

inner join data.postal_address_data as postal on
org.org_postal_add_id= postal.pad_id

left join data.telefon_data as fax on
fax.td_id=org.org_fax_id

where mu_id=(
select fl_fed_id from org.federation_leader as orgD
inner join data.main_user on 
orgD.fl_fed_id=data.main_user.mu_id
where fl_mu_id=26 and mu_active=true
)