#Bookstore

Bookstore webapp to save (adm side) and buy books (user side). Symfony 4 and mysql

DB Model:

author: id,name,comment,rating,votes
book: id,title,description,rating,votes,author_id(foreign key)
genre: id,name,description
genre_book: genre_id(foreign key),book_id(foreign key)

Tue 14/08:
Entities and database created (through Doctrine).