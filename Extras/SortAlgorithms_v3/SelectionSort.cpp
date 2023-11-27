#include <iostream>
#include "Functions.h"

void SelectionSort(long vet[], long size)
{
	for (int s = 0; s < size; s++) {
		for (int i = s+1; i < size; i++)
		{
			if (vet[s] > vet[i])
			{
#ifdef _DEBUG_
				show_color(vet, size, s, i);
#endif // _DEBUG_
				swap(vet, s, i);
			}
		}
	}
}
