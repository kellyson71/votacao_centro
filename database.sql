CREATE DATABASE IF NOT EXISTS votacao_centro
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE votacao_centro;

CREATE TABLE IF NOT EXISTS homenageados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    imagem VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS votos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    homenageado_id INT NOT NULL,
    ip_votante VARCHAR(45) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    data_voto DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (homenageado_id) REFERENCES homenageados(id),
    UNIQUE KEY voto_unico (ip_votante),
    UNIQUE KEY voto_cpf (cpf)
);

INSERT INTO homenageados (nome, imagem, descricao) VALUES
(
    'Francisco Augusto de Queiroz (Xixico)',
    'img/Foto Xixico.png',
    'Francisco Augusto de Queiroz (Xixico) construiu uma trajetória de dedicação ao serviço público e ao povo de Pau dos Ferros. Servidor público aposentado pela Câmara Federal, exerceu com compromisso e responsabilidade o cargo de vereador por três mandatos.\n\nFoi eleito pela primeira vez em 1996, atuando entre 1997 e 2000. Retornou ao Legislativo em 2016, cumprindo mandato de 2017 a 2020, e foi reeleito em 2020, exercendo sua terceira legislatura até novembro de 2022.\n\nSua caminhada foi marcada pelo trabalho, pela proximidade com a população e pelo compromisso com o bem coletivo, deixando um legado de respeito e serviço à comunidade.\n\nEm novembro de 2022, faleceu vítima de câncer, deixando saudade e reconhecimento por tudo que representou para o município.'
),
(
    'Francisco de Sales Paiva',
    'img/Foto Francisco.png',
    'Francisco de Sales Paiva teve uma trajetória marcada pelo compromisso com a justiça e com as pessoas. Como advogado provisionado, dedicou-se a defender os mais necessitados, tornando-se reconhecido por sua firmeza e eloquência. Também foi poeta e um defensor incansável dos menos favorecidos, deixando sua marca na vida de muitos.\n\nFoi o primeiro Diretor Administrativo do Foro Municipal Dr. Jaime Jenner de Aquino, contribuindo para a organização da instituição. Atuou ainda como assessor de imprensa no primeiro governo municipal de Dr. Nilton Figueiredo e, posteriormente, como Assessor Especial de Gabinete, com forte atuação na área jurídica. Exerceu a função de Assessor Parlamentar na Câmara Municipal de Pau dos Ferros/RN.'
),
(
    'Padre Sátiro Cavalcanti Dantas',
    'img/Foto Padre Sátiro.png',
    'Padre Sátiro Cavalcanti Dantas, filho de Pau dos Ferros, construiu uma trajetória marcada pela fé, pela educação e pelo compromisso com a formação de pessoas. Sacerdote e educador, dedicou sua vida ao ensino e à construção do conhecimento, sendo responsável pela formação de gerações de jovens e pelo fortalecimento da educação no Rio Grande do Norte.\n\nSua atuação foi fundamental tanto na educação básica quanto no ensino superior, deixando contribuições importantes para instituições e projetos educacionais.\n\nReconhecido por sua dedicação, sabedoria e espírito de serviço, tornou-se uma das grandes referências educacionais e religiosas da região.\n\nFaleceu em 27 de novembro de 2023, aos 93 anos, deixando um legado que permanece vivo na história e na vida de todos que foram impactados por sua missão.'
);
