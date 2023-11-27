#include <iostream>
#include <climits>
#include "Functions.h"

void MinMaxSort(long vet[], long size)
{
    long min = LONG_MAX;
    long max = LONG_MIN;
    long min_indx = 0;
    long max_indx = 0;
    long i = 0;
    long j = size;
    bool repeat;

    while (i < j)
    {
        repeat = false;
        for (long indx = i; indx < j; indx++)
        {
            if (vet[indx] < min)
            {
                min_indx = indx;
                min = vet[indx];
            }
            if (vet[indx] > max)
            {
                max_indx = indx;
                max = vet[indx];
            }
        }
        if (i < min_indx)
        {
            swap(vet,i,min_indx);
            show(vet, size);

        }

#ifdef _DEBUG_
        //std::cout << "\n i = " << i << " j = " << j << std::endl;
        show_color(vet, size, i, min_indx);
#endif // _DEBUG_
        if (j > max_indx)
        {
            if (vet[max_indx] == max)
            {
                swap(vet,j-1,max_indx);
            }
            else
            {
                repeat = true;
            }
        }

#ifdef _DEBUG_
        std::cout << "\n i = " << i << " j = " << j << std::endl;
        show_color(vet, size, j-1, max_indx);
#endif // _DEBUG_
        if (!repeat)
        {
            i++;
            j--;
        }

        min_indx = i;
        max_indx = i;
        min=LONG_MAX;
        max=LONG_MIN;

    }
}
