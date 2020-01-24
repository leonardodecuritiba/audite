<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Messages Language Lines
	|--------------------------------------------------------------------------
	| Model - Procedure Type - Message Type
	| Example 1: Fans (S)tore (S)uccess
	| Example 2: Fans (U)pdate (E)rror
	*/
	'store_ok'    => 'Cadastro solicitado com sucesso. Verifique seu e-mail para confirmá-lo!',
	'validate_ok' => 'Cadastro realizado com sucesso.',
	'contato_ok'  => 'Contato enviado com sucesso.',
	'username'    => [
		'sent' => 'Um lembrete de LOGIN foi enviado para o seu e-mail!',
	],
	'success'  => 'Sucesso.',
    'password_ok' => 'Senha alterada com sucesso!',
	'crud'        => [
		'M'    => [
			//IMPORT
			'IMPORT' => [
				'GET-FORM'   => 'Importar :name',
				'TITLE-FORM' => 'Importar :name',
			],
			//CREATE
			'CREATE' => [
				'GET-FORM'   => 'Novo :name',
				'TITLE-FORM' => 'Cadastrar Novo :name',
			],
			//EDIT
			'EDIT'   => [
				'TITLE-FORM' => 'Editar :name',
			],
			//STORE
			'STORE'  => [
				'SUCCESS'      => ':name cadastrado com sucesso!',
				'SUCCESS-MANY' => ':name cadastrados com sucesso!',
				'ERROR'        => 'Falha ao cadastrar o :name, tente novamente.',
				'ERROR-MANY'   => 'Falha ao cadastrar os :name, tente novamente.',
			],
			//ADD
			'ADD'  => [
				'SUCCESS'      => ':name adicionado com sucesso!',
				'SUCCESS-MANY' => ':name adicionado com sucesso!',
				'ERROR'        => 'Falha ao adicionar o :name, tente novamente.',
				'ERROR-MANY'   => 'Falha ao adicionar os :name, tente novamente.',
				'DUPLICATE'     => 'Este :name já foi adicionado!',
			],
			//UPDATE
			'UPDATE' => [
				'SUCCESS'      => ':name atualizado com sucesso!',
				'SUCCESS-MANY' => ':name atualizados com sucesso!',
				'ERROR'        => 'Falha ao atualizar o :name, tente novamente.',
				'ERROR-MANY'   => 'Falha ao atualizar os :name, tente novamente.',
			],
			//DELETE
			'DELETE' => [
				'SUCCESS'      => ':name removido com sucesso!',
				'SUCCESS-MANY' => ':name removidos com sucesso!',
				'ERROR'        => 'Falha ao remover o :name, tente novamente.',
				'ERROR-MANY'   => 'Falha ao remover os :name, tente novamente.',
			],
			//SEARCH
			'SEARCH' => [
				'SUCCESS'      => 'Foi encontrado um :name!',
				'SUCCESS-MANY' => 'Foram encontrados :count :name!',
				'ERROR'        => 'Nenhum :name encontrado!',
			],
            //CONFIRM
            'CONFIRM' => [
                'SUCCESS'      => ':name confirmado com sucesso!',
                'SUCCESS-MANY' => ':name confirmados com sucesso!',
                'ERROR'        => 'Falha ao confirmar o :name, tente novamente.',
                'ERROR-MANY'   => 'Falha ao confirmar os :name, tente novamente.',
            ],
            //DENY
            'DENY' => [
                'SUCCESS'      => ':name negado com sucesso!',
                'SUCCESS-MANY' => ':name negados com sucesso!',
                'ERROR'        => 'Falha ao negar o :name, tente novamente.',
                'ERROR-MANY'   => 'Falha ao negar os :name, tente novamente.',
            ],
            //APPROVE
            'APPROVE' => [
                'SUCCESS'      => ':name aprovado com sucesso!',
                'SUCCESS-MANY' => ':name aprovados com sucesso!',
                'ERROR'        => 'Falha ao aprovar o :name, tente novamente.',
                'ERROR-MANY'   => 'Falha ao aprovar os :name, tente novamente.',
            ],
            //DISAPPROVE
            'DISAPPROVE' => [
                'SUCCESS'      => ':name desaprovado com sucesso!',
                'SUCCESS-MANY' => ':name desaprovados com sucesso!',
                'ERROR'        => 'Falha ao desaprovar o :name, tente novamente.',
                'ERROR-MANY'   => 'Falha ao desaprovar os :name, tente novamente.',
            ],
            //IMPORT
            'IMPORT'  => [
                'GET-FORM'      => 'Importar :name',
                'TITLE-FORM'    => 'Importar :name',
                'SUCCESS'      => ':name importado com sucesso!',
                'SUCCESS-MANY' => ':name importados com sucesso!',
                'ERROR'        => 'Falha ao importar o :name, tente novamente.',
                'ERROR-MANY'   => 'Falha ao importar os :name, tente novamente.',
            ],
		],
		'F'    => [
			//CREATE
			'CREATE' => [
				'GET-FORM'   => 'Nova :name',
				'TITLE-FORM' => 'Cadastrar Nova :name',
			],
			//EDIT
			'EDIT'   => [
				'TITLE-FORM' => 'Editar :name',
			],
			//STORE
			'STORE'  => [
				'SUCCESS'      => ':name cadastrada com sucesso!',
				'SUCCESS-MANY' => ':name cadastradas com sucesso!',
				'ERROR'        => 'Falha ao cadastrar a :name, tente novamente.',
				'ERROR-MANY'   => 'Falha ao cadastrar as :name, tente novamente.',
			],
			//ADD
			'ADD'  => [
				'SUCCESS'      => ':name cadastrada com sucesso!',
				'SUCCESS-MANY' => ':name cadastradas com sucesso!',
				'ERROR'        => 'Falha ao adicionar a :name, tente novamente.',
				'ERROR-MANY'   => 'Falha ao adicionar as :name, tente novamente.',
				'DUPLICATE'     => 'Esta :name já foi adicionada!',
			],
			//UPDATE
			'UPDATE' => [
				'SUCCESS'      => ':name atualizada com sucesso!',
				'SUCCESS-MANY' => ':name atualizadas com sucesso!',
				'ERROR'        => 'Falha ao atualizar a :name, tente novamente.',
				'ERROR-MANY'   => 'Falha ao atualizar as :name, tente novamente.',
			],
			//DELETE
			'DELETE' => [
				'SUCCESS'      => ':name removida com sucesso!',
				'SUCCESS-MANY' => ':name removidas com sucesso!',
				'ERROR'        => 'Falha ao remover a :name, tente novamente.',
				'ERROR-MANY'   => 'Falha ao remover as :name, tente novamente.',
			],
			//SEARCH
			'SEARCH' => [
				'SUCCESS'      => 'Foi encontrada uma :name!',
				'SUCCESS-MANY' => 'Foram encontradas :count :name!',
				'ERROR'        => 'Nenhuma :name encontrada!',
			],
            //CONFIRM
            'CONFIRM' => [
                'SUCCESS'      => ':name confirmada com sucesso!',
                'SUCCESS-MANY' => ':name confirmadas com sucesso!',
                'ERROR'        => 'Falha ao confirmar a :name, tente novamente.',
                'ERROR-MANY'   => 'Falha ao confirmar as :name, tente novamente.',
            ],
            //DENY
            'DENY' => [
                'SUCCESS'      => ':name negada com sucesso!',
                'SUCCESS-MANY' => ':name negadas com sucesso!',
                'ERROR'        => 'Falha ao negar a :name, tente novamente.',
                'ERROR-MANY'   => 'Falha ao negar as :name, tente novamente.',
            ],
            //APPROVE
            'APPROVE' => [
                'SUCCESS'      => ':name aprovada com sucesso!',
                'SUCCESS-MANY' => ':name aprovadas com sucesso!',
                'ERROR'        => 'Falha ao aprovar a :name, tente novamente.',
                'ERROR-MANY'   => 'Falha ao aprovar as :name, tente novamente.',
            ],
            //DISAPPROVE
            'DISAPPROVE' => [
                'SUCCESS'      => ':name desaprovada com sucesso!',
                'SUCCESS-MANY' => ':name desaprovadas com sucesso!',
                'ERROR'        => 'Falha ao desaprovar a :name, tente novamente.',
                'ERROR-MANY'   => 'Falha ao desaprovar as :name, tente novamente.',
            ],
            //IMPORT
            'IMPORT'  => [
                'GET-FORM'      => 'Importar :name',
                'TITLE-FORM'    => 'Importar :name',
                'SUCCESS'      => ':name importada com sucesso!',
                'SUCCESS-MANY' => ':name importadas com sucesso!',
                'ERROR'        => 'Falha ao importar a :name, tente novamente.',
                'ERROR-MANY'   => 'Falha ao importar as :name, tente novamente.',
            ],
		],

		//VALIDATE
		'MVS'  => ':name validado com sucesso!',
		'MVE'  => 'Erro ao validar o :name!',
		'FVS'  => ':name validada com sucesso!',
		'FVE'  => 'Erro ao validar a :name!',

		//ACTIVE
		'MAS'  => ':name ativado com sucesso!',
		'MAE'  => 'Erro ao ativar o :name!',
		'FAS'  => ':name ativada com sucesso!',
		'FAE'  => 'Erro ao ativar a :name!',

		//DISACTIVE
		'MDAS' => ':name desativado com sucesso!',
		'MDAE' => 'Erro ao desativar o :name!',
		'FDAS' => ':name desativada com sucesso!',
		'FDAE' => 'Erro ao desativar a :name!',


		//DATA
		'MDTS' => 'Dados do :name',
		'MDTE' => ':name não encontrado',
		'FDTS' => 'Dados da :name',
		'FDTE' => ':name não encontrada',

		//LOGGED
		'MLS'  => ':name logado com sucesso!',
		'MLE'  => 'Login/senha inválidos!',
		'MLVE' => 'Este usuário ainda não foi validado! Por favor, clique no link enviado por email para validar sua conta!',

		//UNLOGGED
		'MULS' => ':name deslogado com sucesso!',
	]

];
