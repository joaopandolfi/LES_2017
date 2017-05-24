Documentação de rotas:

## === Modelagem de comunicação REST Cliente servidor ===

'''
/*Login Route*/
[ip]/user/login/{user}/{pass}
{user} => Em Base64
{pass} => Md5
@returns
{success: 1 or 0,
 error: {String},
 data:{
	user_id: {int},
	hash: {String},
	name: {String},
	email: {String},
	url_picture: {String}
	}
}

/*Show all Trips*/
[ip]/trip/all
@returns
{success: 1 or 0,
 error: {String},
 data:{
	trips:[
			{
			url_picture: {String},
			title:{String},
			name_user:{String},
			short_route: {String},
			rate: {int},
			id_trip: {int}
			}
		]
	}
}


/*Show Trip*/
@returns
{success: 1 or 0,
 error: {String},
 data:{
	url_picture: {String},
	title:{String},
	name_user:{String},
	short_route: {String},
	rate: {int},
	id_trip: {int},
	comments: {String},
	pictures: [
			{
			label: {String},
			url:{String}
			}
		],
	route:[
			{
			id_place: {Int},	
			name_place:{String},
			location:{lat:{double}, lng:{double}},
			price: {Double}
			}
		]
	}
}
'''

##  ===== INTERACTIONS WITH TRIP

'''
/* Like Trip */
[ip]/trip/like/{id_trip}/{id_user}/{like_or_unlike}/
{id_trip} => Int por enquanto
{id_user} => Int por enquanto
{like_or_unlike} => 1 or 0

/* I will to this fucking crazy Trip */
[ip]/trip/follow/{id_trip}/{id_user}/{follow}/
{id_trip} => Int por enquanto
{id_user} => Int por enquanto
{folllow} => 1 or 0

/* When i have money i will go {i don't have money} */
[ip]/trip/idhm/{id_trip}/{id_user}/{iwill}/
{id_trip} => Int por enquanto
{id_user} => Int por enquanto
{iwill} => 1 or 0

/* Rate Trip */
[ip]/trip/rate/{id_trip}/{id_user}/{rate}/
{id_trip} => Int por enquanto
{id_user} => Int por enquanto
{rate} => double

'''

## ===== USER ROUTES

'''
/*My trips*/
[ip]/user/trips/my/{user_id}/
{user_id} => Int por enquanto
@returns
{success: 1 or 0,
 error: {String},
 data:{
	trips:[
			{
			url_picture: {String},
			title:{String},
			name_user:{String},
			short_route: {String},
			rate: {int},
			id_trip: {int}
			}
		]
	}
}

/*New Trip*/
[ip]/user/trips/new/{user_id}/{hash}/
{user_id} => Int por enquanto
{hash} => String {Hash né tio}

@send by post
$data = {
	title: {String},
	short_route: {String},
	comments: {String}	
}

@returns
{success: 1 or 0,
 error: {String},
 data:{
	id_trip: {int}
	}
}

/* Add Images on Trip */
[ip]/trip/images/upload/{trip_id}/{user_id}/{hash}/
{trip_id} => Int por enquanto (Id da trip)
{user_id} => Int por enquanto (Id do usuário que está enviando as imagens)
{hash} => String (Hash do usuário, verificação dupla)

@Send by POST
$files
{Padão de upload de arquivos}
$labels = [{label:{String}}]
{Array padrão com os labels ordenados em relação as imagens}

@returns
{success: 1 or 0,
 error: {String},
 data:{
	images:[
			{
			label:{String},
			url:{String}
			}
		]
	}
}

/* Add Routes on Trip */
[ip]/trip/routes/add/{trip_id}/{user_id}/{hash}/
{trip_id} => Int por enquanto (Id da trip)
{user_id} => Int por enquanto (Id do usuário que está enviando as imagens)
{hash} => String (Hash do usuário, verificação dupla)

@Send by POST
$data = { 
	routes:[
			{
			name: {String},
			location: {lat:{Double},lng:{Double}},
			price: {Double}
			}
		]
}

@returns
{success: 1 or 0,
 error: {String},
 data:{}
}

'''
