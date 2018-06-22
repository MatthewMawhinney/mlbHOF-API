# MLB Hall of Fame API

## Introduction

This webservice was created as simple project during my time as a Web Development student. The purpose was to create a RESTful API service that returned a single JSON object generated from a database source. This service is related to the theme of "The History of the MLB" and with that in mind I created the MLB HOF API, the service takes a single call and returns a JSON object containing data for players who has been inducted into the MLB Hall of Fame since its inception in 1936. The webservice returns the first name, last name, position, team, and year inducted for each player.

Although it provides a niche data source, it is available for use in your applications where you can find it useful. It will allow you to quickly access my data source rather than having to compile it yourself.

![alt text](https://dugoutdynastysports.files.wordpress.com/2016/02/major-league-baseball-logo-for-nicholas-alahverdian-blog.png?w=1000 "MLB Logo")

## Instruction

The MLB HOF API returns JSON, there is no need to specify the response datatype. The service requires an authentication key, which at the current iteration of the API is one standard key listed here.

#### JfKerLsuQ8IfET87Cg

The key is appended as a parameter to the service's url, then a call can simply be made by creating a AJAX call to the API URL, this will then then return the JSON object. Without the key you will be unable to access the API and receive an error in the JSON returned as well as your developer console.

```json
{ 
    "Status": {
        "Code": "401",
        "Message": "User is unauthorized, please enter API Key correctly"
    },
    "Results": null
}
```

### Making a Call

As mentioned above, a call to the MLB HOF is as simple as making an AJAX request to the URL listed below:

> http://mattmawhinney.com/mlbHOF/?key=JfKerLsuQ8IfET87Cg

Below is an example of a simple AJAX request to the API:

```javascript
//call webservice asynchronously and store the JSON string in a variable
//convert the JSON string to a object that can be looped over
var hof;
$.ajax({
    url: "http://mattmawhinney.com/mlbHOF/?key=JfKerLsuQ8IfET87Cg",
    success: function(results){
        hof = JSON.parse(results);
        console.log(hof);
    }
});
```
### Filtering Results

The webservice allows the user to filter the results that are returned by three categories; position, team, and year_in. By adding any, or a combination as parameters to the URL the user can filter the data set returned. There is an example below:

#### NOTE: In Version 1.0 the webservice only allows for one filter for each parameter, more than one will result in an error.

```javascript
//url is appended with team, position, andyear to filter what is returned before your application 
//accesses it.
$.ajax({
    url: "http://mattmawhinney.com/mlbHOF/?key=JfKerLsuQ8IfET87Cgteam=Detroit Tigers&position=CF",
    success: function(results){
        var hof = JSON.parse(results);
        console.log(hof);
    }
});
```

Filtering the content using the parameters allows for soft searching, for example, if ```position=f``` is applied all positions containing 'f' anywhere will be returned, LF, CF, RF. The same applies to both the ```team``` and ```year``` parameters. 


### Response Example

A call to the webservice will return a collection of players as a JSON string, once ```JSON.parse(results)``` is stored in a variable it is now a JSON object. This is an example of a single player return. However, the call will likely return more objects from the database and the JSON will be much longer.

```JSON
{
    "Status": {
        "Code": "200",
        "Message": "OK"
    },
    "Results": [
        {
            "id": "1",
            "first_name": "Ty",
            "last_name": "Cobb",
            "position": "CF",
            "team": "Detroit Tigers",
            "year_in": "1936"
        }
    ]
}
```

### Error Messages

In case of an error in calling the service a JSON object will still be returned, this object will hold the error message.

If the parameter filters used return no results you will not receive an error message but rather an empty array. Below is an example of the various errors that you will receive from the service.

```json
{ 
    "Status": {
        "Code": "401",
        "Message": "User is unauthorized, please enter API Key correctly"
    },
    "Status": {
        "Code": "200",
        "Message": "OK"
    },
    "Status": {
        "Code": "500",
        "Message": "Server Error, please try again"
    }
}
```

## Examples

As shown in the code above, in the AJAX call the user can store the results in a variable they define. The user is then able to access the object through the variable ```hof``` or whatever name is given.

You can then use JavaScript object notation to access the different objects and their specific properties.

```javascript
//request the entire dataset then stringify and assign it to a <pre> element 
//to then read the JSON in the browser window
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>MLB HOF API</title>
    </head>
    <body>
        <pre id="json"></pre>
    <script type="text/javascript">
        var div = document.getElementById('json');
        $.ajax({
            url: "http://mattmawhinney.com/mlbHOF/?key=JfKerLsuQ8IfET87Cg",
            success: function(results){
                var hof = JSON.parse(results);
                console.log(hof);
                div.innerHTML = JSON.stringify(hof, undefined, 2);
            }
        });
    </script>
    </body>
</html>
```

## Contact

The easiest way to bring up a concern would be to raise an issue with the API in this repo, if you need something else feel free to email me. If you are having issues making a call, or receiving JSON data from the MLB HOF API I can be contacted by email at me@mattmawhinney.com.

Any other questions, or suggesions about the API can also be directed to the email above. I'd love to hear any feedback or if you are using the data from this application I'd like to see the applications you are using it in!

## Terms of Use

Please review the terms of service of The MLB HOF API, you may only use the API if your uses meets the guidlines listed below. Being a work in progress the terms may be updated without notice, please review them everytime you plan to access our data as they may have changed.

### Terms

Because this is a small project run by one individual I cannot guarentee that the service will be running available 100% of the time and that any downtime, data loss, or other interuptions are at the risk of the user and MLB HOF API will not be liable for any costs.

The website, its features, and functionality are owned by Matt Mawhinney and are protected by Canadian and international copyright, trademark, patent, trade secret and other intellectual property or proprietary rights laws. The MLB HOF API is in no way affiliated or supported by the MLB or MLBPA in any way.

All content created using the API are the responsibility of the user making the API call.

You are permitted to use the Website for your personal, non-commercial use, or legitimate business purposes, provided that your activities are lawful and in accordance with these Terms of Service. Prohibited uses include violation of laws and regulations, hacking the Website in any manner. No right, title or interest in or to the Website or any content on the site is transferred to you, and all rights not expressly granted are reserved.
