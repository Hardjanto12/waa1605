WITH
    tbl_acc
    AS
    (
        SELECT ROW_NUMBER() OVER (
                  ORDER BY 
                          kdac ASC
                  ) row_num, *
        from acc
    )
SELECT
    *
FROM
    tbl_acc
WHERE 
              row_num >= 0 AND
    row_num <= 50;


Select *
from acc;

SELECT ROW_NUMBER() OVER (
                    ORDER BY 
                    grup ASC
                    ) row_num, *, case when grup='1' then 'Supplier' when grup='2' then 'Customer' end as grp
FROM sub
ORDER By grup, sub ASC

