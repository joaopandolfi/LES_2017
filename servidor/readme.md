Documentação de rotas:

## === Modelagem de comunicação REST Cliente servidor ===

```
/*Login Route*/ -> OK
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

/*Show all Trips*/ -> OK
[ip]/trip/all
@returns
{success: 1 or 0,
 error: {String},
 data:{
	trips:[
			{
			url_user_picture: {String},
			title:{String},
			name_user:{String},
			/*tag: {String},*/
			short_route: {String}, /*Abreveação da rota*/
			rate: {int},
			id_trip: {int},
			create_time: {String} /* SQL Format */
			}
		]
	}
}


/*Show Trip*/ -> OK
[ip]/trip/show/{id}
@returns
{success: 1 or 0,
 error: {String},
 data:{
	url_user_picture: {String},
	title:{String},
	/*name_user:{String},*/
	short_route: {String},
	rate: {int},
	/*likes: {int},*/
	id_trip: {int},
	description: {String},
	tags: [{String},{String}],
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
			url_picture: {String},
			likes: {int}
			/*location:{lat:{double}, lng:{double}},*/
			/*price: {Double}*/
			}
		]
	},
	comments: [
		{
		url_user_picture: {String},
		name_user: {int},
		comment:{String},
		date_time:{String} /* SQL FORMAT */
		}
	]
}
```

## ====> PLACE INTERACTIONS

```
/*Show Place*/ -> OK
[ip]/place/show/{id_place}
@returns
{success: 1 or 0,
 error: {String},
 data:{	
	id_place: {Int},	
	name_place:{String},
	url_picture: {String},
	likes: {int},
	location:{lat:{double}, lng:{double}},
	description:{String},
	address: {String},
	site: {String},
	tel: {String}
}

/*Search Place*/ => OK
[ip]/place/search/{query_string}
{query_string} => Em Base64
@returns
{success: 1 or 0,
 error: {String},
 data:{	
	places:[
			{
			id_place: {Int},	
			name_place:{String},
			url_picture: {String}
			}
	]
}


/*New place*/
Não terá rota :D

```

## ===== INTERACTIONS WITH TRIP

```
/* Like Trip */
[ip]/trip/like/{id_trip}/{id_user}/{hash}/{like_or_unlike}/
{id_trip} => Int por enquanto
{id_user} => Int por enquanto
{hash} => String 
{like_or_unlike} => 1 or 0

/* I will to this fucking crazy Trip, Follow button */
[ip]/trip/follow/{id_trip}/{id_user}/{hash}/{follow}/
{id_trip} => Int por enquanto
{id_user} => Int por enquanto
{hash} => String								
{folllow} => 1 or 0

/* New Comment */
[ip]/trip/comment/{id_trip}/{id_user}/{hash}/
{id_trip} => Int por enquanto
{id_user} => Int por enquanto
{hash} => String 
{comment} => String
```

#==> Disabled
```
/* When i have money i will go {i don't have money} */
[ip]/trip/idhm/{id_trip}/{id_user}/{iwill}/
{id_trip} => Int por enquanto
{id_user} => Int por enquanto
{iwill} => 1 or 0
```

#==> Disabled
```
/* Rate Trip */
[ip]/trip/rate/{id_trip}/{id_user}/{rate}/
{id_trip} => Int por enquanto
{id_user} => Int por enquanto
{rate} => double
```

## ===== USER ROUTES

```
/*Register Route*/
[ip]/user/register/
@send by post
$data = {
	name: {String},
	email: {String},
	pass: {String},
}
{name} => Em Base64
{email} => Em Base64

@returns
{success: 1 or 0,
 error: {String},
 data:{
	id_user: {int}
	}
}

/*Set user Image*/
[ip]/user/new/image/{user_id}/{hash}/
@send by post
$data = {
	url_image: {String}
}

@returns
{success: 1 or 0,
 error: {String},
 data:{}
}


/*My trips*/ ==> IGUAL O FEED // WHERE DIFERENTE
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

```

## ===== CREATING TRIP
```

/*New Trip*/
[ip]/user/trips/new/{user_id}/{hash}/
{user_id} => Int por enquanto
{hash} => String {Hash né tio}

@send by post
$data = {
	title: {String},
	short_route: {String},
	description: {String},
	tags:{String} (<item>;<item>)
}

@returns
{success: 1 or 0,
 error: {String},
 data:{
	id_trip: {int}
	}
}

/*Add Images on Trip*/
[ip]/trip/images/upload/{trip_id}/{user_id}/{hash}/
{trip_id} => Int por enquanto (Id da trip)
{user_id} => Int por enquanto (Id do usuário que está enviando as imagens)
{hash} => String (Hash do usuário, verificação dupla)

@Send by POST
$files
{Padão de upload de arquivos}
$labels = [{label:{String}}]
$_FILES["photos"] <== POST contendo as imagens
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

/*Add Routes on Trip*/
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
```