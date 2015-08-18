Parse to UML
===================

This is a very basic script based on the **[Parse](https://www.parse.com/)** [PHP-SDK](https://github.com/ParsePlatform/parse-php-sdk). The goal is to generate automatically a class diagram from your Parse objects. You can choose which objects to include in the diagram.

The code is pretty straight forward but I'll explain how it works. 

How to install
----------
First you need these things:
>- Have a Parse App (You'll need the AppID, REST-key and the MasterKey).
>- Install the PHP-SDK (using composer or download the files).
>- Get the files from this repo.
>- Change the name of `config-sample.php` to `config.php` and copy-paste the keys of your app.
>- Read the code from line `24` to line `44` and change the objects in the example according to the ones you want to generate the UML for.
>- Run index.php a file called uml-xx-xx-xxx_xxxx.txt should download.
>- ???
>- Profit !

Cool but now I have a .txt file, this isn't UML ! 

How to open the .TXT file 
-------------

The file you'll download is written for **[PlantUML](http://plantuml.com/)** which is a really cool and simple way to write UML. It can take text files and generate diagrams, the images can be generated in PNG, in SVG or LaTeX format.

You need to [download](http://plantuml.com/download.html) PlantUML.

Because we're interested in a Class Diagram, PlantUML requires **[Graphviz](http://plantuml.com/graphvizdot.html)** to render the diagrams. 

Because Graphviz's server is running on boiled potatoes, you might not be able to [download it](https://drive.google.com/a/esprit.tn/file/d/0B-7zQ-BYras-N2FxT1FTMmFpSHM/view?usp=sharing) directly from their servers. 
I have uploaded for you the latest Windows installer.

>If you're paranoid or something, you can check the md5. 
  
* Now that we have the .txt an PlantUML running you just open it, and select the directory were you put the downloaded file.

Then, ... **magic**!



    @startuml   
	class _Date { 
	 date 
	 timezone_type 
	 timezone 
	 }
	class User { 
	objectId
	_Date createdAt
	_Date updatedAt
	blabla
	email
	username
	} 
	class Temperature { 
	objectId
	_Date createdAt
	_Date updatedAt
	tmp
	available
        }
    @enduml


The file above outputs this diagram:
![Generated UML](http://i.imgur.com/GMwCRUp.png)

###TODO
* Relation mapping.
* XMI UML generation. (StarUML/VisualParagidm/...)
* Take over the world.