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

