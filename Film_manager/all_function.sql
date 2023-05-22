/** Add Users **/

CREATE OR REPLACE FUNCTION add_user(u_name varchar, u_email varchar, u_password varchar) RETURNS INT AS
$$
BEGIN
	INSERT INTO public.user (user_name, user_email, user_password)  VALUES(u_name, u_email, u_password);
	return 1;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION validate_user(u_email varchar,u_password varchar)
RETURNS varchar AS
$$ 
BEGIN
  SELECT *
    FROM user
    WHERE user_email=u_email
    AND user_password=u_password;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION delete_content(deleted_id INT, deleted_tbl_name VARCHAR, deleted_column_name VARCHAR) RETURNS VOID AS
$$
BEGIN
   EXECUTE 'DELETE FROM ' || deleted_tbl_name || ' WHERE ' || deleted_column_name || '=' || deleted_id;
END;
$$ LANGUAGE plpgsql;

/* actor module */

CREATE OR REPLACE FUNCTION op_person(operation varchar,p_name varchar,p_id integer) RETURNS INT AS
    $$
    BEGIN
    if operation = 'add' then
      INSERT INTO related_person(person_name) VALUES (p_name,p_role);
      return 1;
    elsif operation='edit' then
          UPDATE related_person SET person_name=p_name WHERE person__id=p_id;      
          return 1;
      end if;
    END;
    $$ LANGUAGE plpgsql;


  CREATE FUNCTION get_person() RETURNS
    TABLE(person_id integer, person_name character varying)
    LANGUAGE plpgsql
    AS
    $$
    BEGIN
      return query
        SELECT
           person.person_id ::integer,
           person.person_name ::VARCHAR,
        FROM
          person
        ORDER BY person_id DESC ;
    END;
    $$;

-- FUNCTION: public.add_edit_actor(character varying, character varying, integer)

-- DROP FUNCTION IF EXISTS public.add_edit_actor(character varying, character varying, integer);

CREATE OR REPLACE FUNCTION public.change_rating(
	movie_id_ integer,
	user_id_ integer,
	rating_ integer,
	submovie_ integer)
    RETURNS integer
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
    BEGIN
	  IF NOT EXISTS (SELECT 1 FROM rating WHERE movie_id = movie_id_ AND user_id = user_id_ AND submovie = submovie_)
	  then
      INSERT INTO rating(movie_id,user_id,rating,submovie) VALUES (movie_id_,user_id_,rating_,submovie_);
    	return 1;
	 else 
          UPDATE rating SET rating = rating_ WHERE movie_id = movie_id_ AND user_id = user_id_ AND submovie = submovie_;
          return 1;
		  end if;
	END;
    
$BODY$;

ALTER FUNCTION public.change_rating(integer, integer, integer, integer)
    OWNER TO postgres;


-- FUNCTION: public.delete_content(integer, character varying, character varying)

-- DROP FUNCTION IF EXISTS public.delete_content(integer, character varying, character varying);

CREATE OR REPLACE FUNCTION public.delete_content(
	deleted_id integer,
	deleted_tbl_name character varying,
	deleted_column_name character varying)
    RETURNS void
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
BEGIN
   EXECUTE 'DELETE FROM public.' || deleted_tbl_name || ' WHERE ' || deleted_column_name || '=' || deleted_id;
END;
$BODY$;

ALTER FUNCTION public.delete_content(integer, character varying, character varying)
    OWNER TO postgres;


-- FUNCTION: public.get_movies()

-- DROP FUNCTION IF EXISTS public.get_movies();

CREATE OR REPLACE FUNCTION public.get_movies(
	)
    RETURNS TABLE(movie_id integer, movie_title character varying, overview character varying, release_year integer, country character varying, genre character varying, type_of integer, submovie_id integer, submovie_name character varying, rating double precision) 
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
    ROWS 1000

AS $BODY$
    BEGIN
      return query
        SELECT
           movie.movie_id ::integer,
           movie.movie_title ::VARCHAR,
		   movie.overview :: VARCHAR,
		   movie.release_year :: integer,
		   movie.country :: VARCHAR,
		   movie.genre :: VARCHAR,
		   0,
		   0,
		   'NA',
		   (SELECT AVG(rating.rating) FROM rating WHERE rating.movie_id = movie.movie_id) :: float
        FROM
          movie
        UNION ALL
		SELECT
           subordinated.movie_id ::integer,
           subordinated.submovie_name ::VARCHAR,
		   subordinated.submovie_overview :: VARCHAR,
		   subordinated.submovie_year :: integer,
		   subordinated.submovie_country :: VARCHAR,
		   subordinated.submovie_genre :: VARCHAR,
		   1,
		   subordinated.submovie_id :: integer,
		   movie.movie_title :: VARCHAR,
		   (SELECT AVG(rating.rating) FROM rating WHERE rating.movie_id = subordinated.submovie_id):: float
        FROM
          subordinated JOIN movie ON movie.movie_id = subordinated.movie_id
        ORDER BY movie_id DESC 
		;
    END;
    
$BODY$;

ALTER FUNCTION public.get_movies()
    OWNER TO postgres;



-- FUNCTION: public.get_one_movie(integer, integer)

-- DROP FUNCTION IF EXISTS public.get_one_movie(integer, integer);

CREATE OR REPLACE FUNCTION public.get_one_movie(
	film_id integer,
	user_id_ integer)
    RETURNS TABLE(movie_title character varying, overview character varying, release_yr character varying, country character varying, genre character varying, rating integer) 
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
    ROWS 1000

AS $BODY$
    BEGIN
      return query
        SELECT
          movie.movie_title::VARCHAR,
          movie.overview::VARCHAR,
		  movie.release_year::VARCHAR,
		  movie.country::VARCHAR,
		  movie.genre::VARCHAR,
		  (SELECT rating.rating FROM rating WHERE movie_id = film_id AND rating.submovie = 0 AND rating.user_id = user_id_)::integer
        FROM
          movie 
        WHERE  movie.movie_id = film_id;
    END;
    
$BODY$;

ALTER FUNCTION public.get_one_movie(integer, integer)
    OWNER TO postgres;


-- FUNCTION: public.get_one_submovie(integer, integer)

-- DROP FUNCTION IF EXISTS public.get_one_submovie(integer, integer);

CREATE OR REPLACE FUNCTION public.get_one_submovie(
	film_id integer,
	user_id_ integer)
    RETURNS TABLE(movie_title character varying, overview character varying, release_yr character varying, country character varying, genre character varying, rating integer) 
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
    ROWS 1000

AS $BODY$
    BEGIN
      return query
        SELECT
          subordinated.submovie_name::VARCHAR,
          subordinated.submovie_overview::VARCHAR,
		  subordinated.submovie_year::VARCHAR,
		  subordinated.submovie_country::VARCHAR,
		  subordinated.submovie_genre::VARCHAR,
		  (SELECT rating.rating FROM rating WHERE movie_id = film_id AND rating.submovie = 1 AND rating.user_id = user_id_)::integer
        FROM
          subordinated
        WHERE  subordinated.submovie_id = film_id;
    END;
    
$BODY$;

ALTER FUNCTION public.get_one_submovie(integer, integer)
    OWNER TO postgres;


CREATE OR REPLACE FUNCTION public.get_recommended_movies(
	user_id_ integer)
    RETURNS TABLE(genre text) 
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
    ROWS 1000

AS $BODY$
    BEGIN
      return query
        SELECT string_agg(movie.genre::VARCHAR, ',') FROM rating JOIN movie on movie.movie_id = rating.movie_id WHERE rating.rating > 2 AND rating.submovie = 0 AND rating.user_id = user_id_;
    END;
    
$BODY$;

ALTER FUNCTION public.get_recommended_movies(integer)
    OWNER TO postgres;


-- FUNCTION: public.op_movie(character varying, character varying, character varying, integer, character varying, character varying, integer)

-- DROP FUNCTION IF EXISTS public.op_movie(character varying, character varying, character varying, integer, character varying, character varying, integer);

CREATE OR REPLACE FUNCTION public.op_movie(
	op_name character varying,
	film_title character varying,
	film_overview character varying,
	film_release_yr integer,
	film_country character varying,
	film_genre character varying,
	film_id integer)
    RETURNS integer
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
    BEGIN
    if op_name = 'add' then
      INSERT INTO movie(movie_title,overview,release_year,country,genre) 
      VALUES (film_title,film_overview,film_release_yr,film_country,film_genre);
      return 1;
    elsif op_name='edit' then
          UPDATE movie SET movie_title=film_title,overview=film_overview,release_year=film_release_yr,country=film_country,genre=film_genre
           WHERE movie_id=film_id;
          return 1;
      end if;
    END;
    
$BODY$;

ALTER FUNCTION public.op_movie(character varying, character varying, character varying, integer, character varying, character varying, integer)
    OWNER TO postgres;


-- FUNCTION: public.op_person(character varying, character varying, integer, character varying, integer)

-- DROP FUNCTION IF EXISTS public.op_person(character varying, character varying, integer, character varying, integer);

CREATE OR REPLACE FUNCTION public.op_person(
	op_name character varying,
	p_name character varying,
	f_id integer,
	roles_name character varying,
	pid integer)
    RETURNS integer
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
    BEGIN
    if op_name = 'add' then
      INSERT INTO person(person_name,film,role_name) VALUES (p_name,f_id,roles_name);
      return 1;
    elsif op_name='edit' then
          UPDATE person SET person_name=p_name,film_id=f_id,role_name=roles_name WHERE person_id=pid;
          return 1;
      end if;
    END;
    
$BODY$;

ALTER FUNCTION public.op_person(character varying, character varying, integer, character varying, integer)
    OWNER TO postgres;


-- FUNCTION: public.op_subordinated_movie(character varying, character varying, character varying, integer, character varying, character varying, integer, integer)

-- DROP FUNCTION IF EXISTS public.op_subordinated_movie(character varying, character varying, character varying, integer, character varying, character varying, integer, integer);

CREATE OR REPLACE FUNCTION public.op_subordinated_movie(
	op_name character varying,
	film_title character varying,
	film_overview character varying,
	film_release_yr integer,
	film_country character varying,
	film_genre character varying,
	movie_id integer,
	film_id integer)
    RETURNS integer
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
    BEGIN
    if op_name = 'add' then
      INSERT INTO public.subordinated (movie_id,submovie_name,submovie_overview,submovie_year,submovie_country,submovie_genre) VALUES (movie_id,film_title,film_overview,film_release_yr,film_country,film_genre);
      return 1;
    elsif op_name='edit' then
          UPDATE public.subordinated SET submovie_name=film_title,submovie_overview=film_overview,submovie_year=film_release_yr,submovie_country=film_country,submovie_genre=film_genre WHERE submovie_id=film_id;
          return 1;
      end if;
    END;
    
$BODY$;

ALTER FUNCTION public.op_subordinated_movie(character varying, character varying, character varying, integer, character varying, character varying, integer, integer)
    OWNER TO postgres;

