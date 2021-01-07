CREATE TABLE `especies`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255),
  PRIMARY KEY (`id`) USING BTREE
);

INSERT INTO `especies` (`id`, `descricao`) VALUES (1, 'Gato');
INSERT INTO `especies` (`id`, `descricao`) VALUES (2, 'Cachorro');
INSERT INTO `especies` (`id`, `descricao`) VALUES (3, 'Coelho');

CREATE TABLE `animais`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(255),
  `dono` varchar(255),
  `especie_id` int(10) UNSIGNED NOT NULL,
  `raca` varchar(255),
  `data_nascimento` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `animais_especie_id_especies_id`(`especie_id`) USING BTREE,
  CONSTRAINT `animais_especie_id_especies_id` FOREIGN KEY (`especie_id`) REFERENCES `especies` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
);

INSERT INTO `animais` (`id`, `nome`, `dono`, `especie_id`, `raca`, `data_nascimento`) VALUES (1, 'Charlie', 'Victor', 2, 'Golden Retriever', '2020-01-08');
INSERT INTO `animais` (`id`, `nome`, `dono`, `especie_id`, `raca`, `data_nascimento`) VALUES (2, 'Bob', 'Victor', 2, 'SRD', '2010-05-01');
