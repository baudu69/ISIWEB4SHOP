INSERT INTO admin (`id`, `username`, `password`)
VALUES (NULL, 'john', SHA1('John+123'));

INSERT INTO categories(`id`, `name`)
VALUES (NULL, 'boissons'),
(NULL, 'biscuits');

INSERT INTO `customers` (`id`, `firstname`, `surname`, `add1`, `add2`,
`city`, `postcode`, `phone`, `email`, `registered`) VALUES
(1, 'Sarah', 'Hamida', 'ligne add1', 'ligne add2', 'Meximieux', '01800',
'0612345678', 's.hamida@gmail.com', 1),
(2, 'Jean-Benoît', 'Delaroche', 'ligne add1', 'ligne add2', 'Lyon',
'69009', '0796321458', 'jb.delaroche@gmx.fr', 1);

INSERT INTO products(`id`, `cat_id`, `name`, `description`, `image`,
`price`)
VALUES (NULL, '1', 'Saveur Impériale', 'Sachet de thé de qualité
supérieure.200 sachets par boite', '', '4.99'),
(NULL, '1', 'Jus d’Orange de Floride', 'Bouteille d’un litre.',
'bestorange-juice.jpg', '0.9');
