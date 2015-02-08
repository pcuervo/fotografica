SELECT P.id, P.post_title, T.name, T.slug FROM wp_posts P
INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
INNER JOIN wp_terms T ON T.term_id = TT.term_id
WHERE P.post_type = 'fotografias'
AND TT.taxonomy IN ('coleccion', 'año', 'fotografo', 'tema')
AND (
	T.slug IN ( SELECT slug FROM wp_terms WHERE slug IN ('fondo-juan-cachu') ) 
	OR T.slug IN ( SELECT slug FROM wp_terms WHERE slug BETWEEN '1947' AND '1947')
	OR T.slug IN ( SELECT slug FROM wp_terms T INNER JOIN wp_term_taxonomy TT ON TT.term_id = T.term_id WHERE slug LIKE 'L%' AND taxonomy = 'año' )
	OR T.name IN ( SELECT name FROM wp_terms WHERE name = '#test' )
)
ORDER BY RAND()
LIMIT 20


SELECT id, COUNT(id) FROM wp_posts P
INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
INNER JOIN wp_terms T ON T.term_id = TT.term_id
WHERE P.post_type = 'fotografias'
AND TT.taxonomy IN ('coleccion', 'año', 'fotografo')
AND (
	T.slug IN ( SELECT slug FROM wp_terms WHERE slug IN ('fondo-juan-cachu') ) 
	OR T.slug IN ( SELECT slug FROM wp_terms WHERE slug BETWEEN '1947' AND '1947')
	OR T.slug IN ( SELECT slug FROM wp_terms T INNER JOIN wp_term_taxonomy TT ON TT.term_id = T.term_id WHERE slug LIKE 'L%' AND taxonomy = 'fotografo' ) 
)
GROUP BY id
HAVING COUNT(id) > 1
ORDER BY RAND()
LIMIT 20


SELECT id, COUNT(id)  FROM wp_posts P
INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
INNER JOIN wp_terms T ON T.term_id = TT.term_id
WHERE P.post_type = 'fotografias' AND TT.taxonomy IN ('tema', 'año') AND (   T.slug IN ( SELECT slug FROM wp_terms WHERE slug  BETWEEN '1940' AND '1950') T.slug IN ( SELECT slug FROM wp_terms WHERE name IN ('#test') )  ) GROUP BY id HAVING COUNT(id) &gt; 1 ORDER BY RAND() LIMIT 20