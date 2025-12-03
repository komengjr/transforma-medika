insert into
    t_price (
        T_PriceT_TestID,
        T_PriceIsCito,
        T_PriceM_CompanyID,
        T_PriceM_MouID,
        T_PricePriority,
        T_PriceAmount,
        T_PriceDisc,
        T_PriceDiscRp,
        T_PriceSubTotal,
        T_PriceOther,
        T_PriceTotal,
        T_PriceUserID
    )
select
    T_TestID T_PriceT_TestID,
    'N' T_PriceIsCito,
    1710 T_PriceM_CompanyID,
    3001 T_PriceM_MouID,
    0 T_PricePriority,
    wil3 T_PriceAmount,
    0 T_PriceDisc,
    0 T_PriceDiscRp,
    wil3 T_PriceSubTotal,
    0 T_PriceOther,
    wil3 T_PriceTotal,
    3 T_PriceUserID
from
    tmp_price_telkomedika
    join t_test on T_TestSasCode = sasCode;
