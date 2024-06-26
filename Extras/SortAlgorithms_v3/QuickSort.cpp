#include <iostream>
#include "Functions.h"

void QuickSort(long vet[], long began, long end,  long size)
{
	long i, j, pivo;
	i = began;
	j = end-1;
	pivo = vet[(began + end) / 2];
	while(i <= j)
	{
		while(vet[i] < pivo && i < end)
		{
			i++;
		}
		while(vet[j] > pivo && j > began)
		{
			j--;
		}
		if(i <= j)
		{
#ifdef _DEBUG_
            show_color(vet,size, i, j);
#endif // _DEBUG_
		    swap(vet, i, j);
			i++;
			j--;
		}
	}
	if(j > began)
		QuickSort(vet, began, j+1, size);
	if(i < end)
		QuickSort(vet, i, end, size);
}
