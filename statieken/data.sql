SELECT datum, COUNT(*) as aantal
FROM tb_tickets
GROUP BY datum
ORDER BY datum;