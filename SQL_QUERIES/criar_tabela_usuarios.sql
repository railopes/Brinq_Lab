use development_umc;
create table usuarios (id int auto_increment primary key,nome varchar(32) not null unique, senha varchar(36) not null,perfil int not null );
ALTER TABLE usuarios AUTO_INCREMENT=1;


insert into usuarios values(rand(),'railopes',md5('13061999'),3);
update usuarios set senha = md5(13061999) where id =1;
insert into usuarios values(0,'ronaldyantony',md5('123456789'),3);
insert into usuarios values(0,'danielafernandes',md5('987654321'),1);

select * from usuarios where senha = 'dec3dd63bd4cb60e008ec043eca90da0';

alter table usuarios add column usuario_valido boolean not null;

update usuarios set usuario_valido = true where id >= 1;
update usuarios set usuario_valido = false where id = 1;
select * from usuarios;