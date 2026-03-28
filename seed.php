<?php
require_once 'db.php';

$pdo->exec('DELETE FROM votos');
$pdo->exec('DELETE FROM homenageados');
$pdo->exec('ALTER TABLE homenageados AUTO_INCREMENT = 1');

$dados = [
    [
        'nome' => 'Francisco Augusto de Queiroz (Xixico)',
        'imagem' => 'img/Foto Xixico.png',
        'descricao' => "Francisco Augusto de Queiroz (Xixico) construiu uma trajetória de dedicação ao serviço público e ao povo de Pau dos Ferros. Servidor público aposentado pela Câmara Federal, exerceu com compromisso e responsabilidade o cargo de vereador por três mandatos.\n\nFoi eleito pela primeira vez em 1996, atuando entre 1997 e 2000. Retornou ao Legislativo em 2016, cumprindo mandato de 2017 a 2020, e foi reeleito em 2020, exercendo sua terceira legislatura até novembro de 2022.\n\nSua caminhada foi marcada pelo trabalho, pela proximidade com a população e pelo compromisso com o bem coletivo, deixando um legado de respeito e serviço à comunidade.\n\nEm novembro de 2022, faleceu vítima de câncer, deixando saudade e reconhecimento por tudo que representou para o município."
    ],
    [
        'nome' => 'Francisco de Sales Paiva',
        'imagem' => 'img/Foto Francisco.png',
        'descricao' => "Francisco de Sales Paiva teve uma trajetória marcada pelo compromisso com a justiça e com as pessoas. Como advogado provisionado, dedicou-se a defender os mais necessitados, tornando-se reconhecido por sua firmeza e eloquência. Também foi poeta e um defensor incansável dos menos favorecidos, deixando sua marca na vida de muitos.\n\nFoi o primeiro Diretor Administrativo do Foro Municipal Dr. Jaime Jenner de Aquino, contribuindo para a organização da instituição. Atuou ainda como assessor de imprensa no primeiro governo municipal de Dr. Nilton Figueiredo e, posteriormente, como Assessor Especial de Gabinete, com forte atuação na área jurídica. Exerceu a função de Assessor Parlamentar na Câmara Municipal de Pau dos Ferros/RN."
    ],
    [
        'nome' => 'Padre Sátiro Cavalcanti Dantas',
        'imagem' => 'img/Foto Padre Sátiro.png',
        'descricao' => "Padre Sátiro Cavalcanti Dantas, filho de Pau dos Ferros, construiu uma trajetória marcada pela fé, pela educação e pelo compromisso com a formação de pessoas. Sacerdote e educador, dedicou sua vida ao ensino e à construção do conhecimento, sendo responsável pela formação de gerações de jovens e pelo fortalecimento da educação no Rio Grande do Norte.\n\nSua atuação foi fundamental tanto na educação básica quanto no ensino superior, deixando contribuições importantes para instituições e projetos educacionais.\n\nReconhecido por sua dedicação, sabedoria e espírito de serviço, tornou-se uma das grandes referências educacionais e religiosas da região.\n\nFaleceu em 27 de novembro de 2023, aos 93 anos, deixando um legado que permanece vivo na história e na vida de todos que foram impactados por sua missão."
    ]
];

$stmt = $pdo->prepare('INSERT INTO homenageados (nome, imagem, descricao) VALUES (?, ?, ?)');
foreach ($dados as $d) {
    $stmt->execute([$d['nome'], $d['imagem'], $d['descricao']]);
}

echo "Dados inseridos com sucesso! " . count($dados) . " homenageados.\n";
