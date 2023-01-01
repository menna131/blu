## This project is divided into 2 parts:
	-# PartOne: (I die dump all the data -- in postman you need to choose "Preview")
		- a. A GET api that have two parameters, start number and
			the end number and should return the count of all numbers
			except numbers with a 5 in it.
			
			- http://127.0.0.1:8000/api/twoNumbss?number_one=10&number_two=30
			- insert 2 numbers
			- you'll get the range of numbers between them except numbers with 5 in them
			
		- b. a GET api that have one parameter named input_string.
			that have the alphabetic string you should return the index of this
			string. 
			-- ex: if input = "BFG" --> the output should be 1515
			
			- http://127.0.0.1:8000/api/letters?string=BFG
			- insert a string
			- the output is the index of this string, as shown in the example
			
		- c. Create a method to  minimum number of moves required to reduce the value of X to 0.
			Where X is the element of an input array
			-- ex: if input array = [3, 4] ---> the output = [3, 3]
			
			- http://127.0.0.1:8000/api/toZero
			- input an array of numbers, and its length
			- output array determining the min number of moves required to reduce the value of each element to 0
			
	-# PartTwo:
		- Create a new api for Authenticating a User
			- make a post api to register a user api will require (email, user name, date of birth, phone number, password)
				- http://127.0.0.1:8000/api/admin/register
				- the body should be as follows:
					{
						"email": "menna@m.com",
						"userName": "menna",
						"dateOfBirth": "04/01/1999",
						"phoneNumber": "01000000000",
						"password": "123456789_Ab"
					}
				- the response should be as follows:
					{
						"message": "user is added successfully",
						"user": {
							"id": 5,
							"userName": "menna",
							"email": "menna@m.com",
							"password": "$2y$10$C6aGltmCHWjCw9Cky9CgIOT.M.tb/gpqVE9cLgetDIOB8jdWQ00Cq",
							"dateOfBirth": "04/01/1999",
							"phoneNumber": "01000000000",
							"created_at": "2022-12-30 23:49:49",
							"updated_at": "2022-12-30 23:49:49"
						}
					}
			- Make an api for user log in
				- http://127.0.0.1:8000/api/admin/login
				- body:
					{
						"email": "menna@m.com",
						"password": "123456789_Ab"
					}
				- response:
					{
						"user": {
							"id": 6,
							"userName": "menna",
							"email": "menna@m.com",
							"dateOfBirth": "04/01/1999",
							"phoneNumber": "01000000000",
							"created_at": "2022-12-31T00:01:00.000000Z",
							"updated_at": "2022-12-31T00:01:00.000000Z"
						},
						"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMGQ2MTM3MGQ2ZWI0ZmNmYjcyYTRkNjIwOWVjZmE0YTc5ZmU2OWVhOWVmNjc3NDNhZmM4ZTJhOTQ1M2YzMGVhMDRhNDJkYmZlNDU5YWEyNDQiLCJpYXQiOjE2NzI0NDUwMTkuMjM0NTE2LCJuYmYiOjE2NzI0NDUwMTkuMjM0NTI0LCJleHAiOjE3MDM5ODEwMTkuMjIzNTMzLCJzdWIiOiI2Iiwic2NvcGVzIjpbXX0.oxLCYWiH3yNRqAMdj9RQ2IcuKR1ByPbtdIu01ij0y70mePXi26eqPrvD_vvzmr6NAk9YpSTZbxlmcsLMHLOkxLpX1eQgWvFVRaoEYu4eJuTtbQecoKU1I16dgbBb1KW-M8BjfROGd2M-mOwjbEl2NJwaDUsN2VFRf81OjYwFd2S7k-Em-UQstyeiA2FaqRqjurGPZGyrGJdMlNCYBQbvVpknM6sxBoZu83vR25zHXhG7_Y7HZQqjHxu3z-ZQzYKG8_8BU9SLhQz62fTK8w4a761e7ix-MFteuEr9ZgXufGgDImhHu9QeFoHEeT6N_Rcx5ei3PEi6thGrZiCaaYYe5bWQdmzSSC6YlxdtJRvpvifwIwfNu5KRMKEAfR4KnXessQN66pTuhRY0lbQfB6Lv4oCrxDjYogT6fG9NJ3sTo5A3sqM5WqDcCZaLh3xPK733hzvSHyWTlSm44RHneG-Hn99PTzV1UwsxXaJDM31kwynq98DjMbF5L9bY2OpCGhs7IEvL1DyjvkmbqFh7pBmlqPDKa6sz-2qfzMn8hEVOQVqS5W3Eysaf0UhMMprrhK_L00pfNFDFchtAXavMp85ly5g6lyyEPqhG6Dwlj4RN1r52OQ7la_iiLHdJiiRbquEH8VYN7p5tp8FjHLAIbI-VG-dfwcUHckP2y81k7SLGNYI"
					}
			- make an api the will get a user by its ID
				- http://127.0.0.1:8000/api/admin/showUser/6
				- no body ... token is a bearer token
				- the response is the user
			- make an api that will get all users
				- http://127.0.0.1:8000/api/admin/getUsers
				- no body ... token is a bearer token
				- the response is all the users
			- make an api that will update user
				- http://127.0.0.1:8000/api/admin/update/6
				- body is whatever attributes you want to update
				- response is the user with its new data, and a message saying the user is successfully updated
			- make an api that will delete user
				- http://127.0.0.1:8000/api/admin/delete/7
				- no body
				- response is a message saying the user is successfully deleted
