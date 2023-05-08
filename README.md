### iLetters - Aggregator API

This is the main microservice in which the client communicates with. In fact, the client never communicates directly
with either of the other microservices but this one.

This microservice relays the requests from the client to the specific microservice/s and returns the response from the 
microservice/s back to the client. All the create, read, update, delete operations pass through to the appropriate microservice.

In the case of a request which includes more than one microservice, the aggregator api will send the request to the associated 
microservices and then go on to combine the results from the various microservices into one response which is then sent to the client.

[Go back to the iLetters project](https://github.com/MlamliLolwane/iLetters)
